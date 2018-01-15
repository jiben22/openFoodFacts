<?php
// src/Controller/AddProductController.php
namespace App\Controller;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\IntegerType;
use Symfony\Component\Form\Extension\Core\Type\NumberType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;

use App\Entity\Additives;
use App\Entity\Brands;
use App\Entity\Countries;
use App\Entity\Ingredients;
use App\Entity\NutritionalInformation;
use App\Entity\Product;

class AddProductController extends Controller
{
  public function AddProduct(Request $request)
  {
      //FORM
      $form = $this->getFormAddProduct();

      $form->handleRequest($request);

      if ($form->isSubmitted() && $form->isValid()) {

          //Retrieve data form Field mapped Product
          $data = $form->getData();
          $product = $data["product"];
          $additives = $data["additives"];
          $brand = $data["brands"];
          $country = $data["country"];
          $ingredients = $data["ingredients"];
          $nutritionalInformation = $data["nutritionalInformation"];

          //TEST
          //$product = $data["product"];
          //var_dump($data);
          //var_dump($product);
          //var_dump($brand);

          // We ADD Product in database
          $this->addProductInDatabase($product, $additives, $brand, $country, $ingredients, $nutritionalInformation);

          return $this->render('products/search.html.twig', array(
        ));
      }

      return $this->render('products/add.html.twig', array(
        'form' => $form->createView(),
    ));
  }

  //Return the fields added in the form to add a product
  public function getFormAddProduct()
  {

      $data = array(
        'product'  => new Product(),
        'additives' => new Additives(),
        'brands' => new Brands(),
        'country' => new Countries(),
        'ingredients' => new Ingredients(),
        'nutritionalInformation' => new NutritionalInformation(),
      );

      //PRODUCT
      // We create the form with createFormBuilder
      $form = $this->createFormBuilder($data)
        ->add('product_name', TextType::class, array(
          'label' => 'Nom du produit',
          'required' => true,
        ))

        ->add('serving_size', TextType::class, array(
          'label' => 'Portion',
          'required' => false,
        ))

        ->add('ingredients_from_palm_oil_n', IntegerType::class, array(
          'label' => 'Nombre d\'ingrédients contenant de l\'huile de palme',
          'required' => false,
        ))

        ->add('ingredients_that_may_be_from_palm_oil_n', IntegerType::class, array(
          'label' => 'Nombre d\'ingrédients pouvant contenir de l\'huile de palme',
          'required' => false,
        ))

        //ADDITIVES
        ->add('additive_fr', TextType::class, array(
          'label' => 'Nom des additives ++',
          'required' => false,
        ))

        //BRANDS
        ->add('brand', TextType::class, array(
          'label' => 'Marque',
          'required' => false,
        ))

        //COUNTRIES
        ->add('country_fr', ChoiceType::class, array(
          'label' => 'Pays',
          'choices' => array(
              "Pays1" => "1",
              "Pays2" => "2",
              "Pays3" => "3",
          ),
          'required' => false,
        ))

        //INGREDIENTS
        ->add('ingredient', TextType::class, array(
          'label' => 'Ingrédients ++',
          'required' => false,
        ))

        //NutritionalInformation
        ->add('nutrition_grade_fr', ChoiceType::class, array(
          'label' => 'Note nutritionnelle',
          'choices' => array(
              "A" => "a",
              "B" => "b",
              "C" => "c",
              "D" => "d",
              "E" => "e",
          ),
          'required' => false,
        ))
        ->add('energy_100g', NumberType::class, array(
          'label' => 'Énergie (pour 100g)',
          'scale' => 4,
          'required' => false,
        ))
        ->add('fat_100g', NumberType::class, array(
          'label' => 'Matières grasses (pour 100g)',
          'scale' => 4,
          'required' => false,
        ))
        ->add('saturated_fat_100g', NumberType::class, array(
          'label' => 'Acides gras saturés (pour 100g)',
          'scale' => 4,
          'required' => false,
        ))
        ->add('cholesterol_100g', NumberType::class, array(
          'label' => 'Cholestérol (pour 100g)',
          'scale' => 4,
          'required' => false,
        ))
        ->add('carbohydrates_100g', NumberType::class, array(
          'label' => 'Hydrate de carbone (pour 100g)',
          'scale' => 4,
          'required' => false,
        ))
        ->add('sugars_100g', NumberType::class, array(
          'label' => 'Sucres (pour 100g)',
          'scale' => 4,
          'required' => false,
        ))
        ->add('fiber_100g', NumberType::class, array(
          'label' => 'Fibres (pour 100g)',
          'scale' => 4,
          'required' => false,
        ))
        ->add('proteins_100g', NumberType::class, array(
          'label' => 'Protéines (pour 100g)',
          'scale' => 4,
          'required' => false,
        ))
        ->add('salt_100g', NumberType::class, array(
          'label' => 'Sel (pour 100g)',
          'scale' => 4,
          'required' => false,
        ))
        ->add('sodium_100g', NumberType::class, array(
          'label' => 'Sodium (pour 100g)',
          'scale' => 4,
          'required' => false,
        ))
        ->add('vitamin_a_100g', NumberType::class, array(
          'label' => 'Vitamine A (pour 100g)',
          'scale' => 4,
          'required' => false,
        ))
        ->add('calcium_100g', NumberType::class, array(
          'label' => 'Calcium (pour 100g)',
          'scale' => 4,
          'required' => false,
        ))
        ->add('iron_100g', NumberType::class, array(
          'label' => 'Fer (pour 100g)',
          'scale' => 4,
          'required' => false,
        ))

        ->add('save', SubmitType::class, array('label' => 'Ajouter'))
        ->getForm();

      return $form;
  }

  public function addProductInDatabase($product, $additive, $brand, $country, $ingredient, $nutritional_information)
  {
    /**
     * Create new PRODUCT
     * @var Product $product
     */
    //Entering data process for product_name (ucfirst)
    $product_cap = strtolower($product->getProductName());
    $product_cap = ucfirst($product_cap);
    $product->setProductName($product_cap);
    $product->setServingSize($product->'serving_size']);
    $product->setAdditivesN($product['additives_n']);
    $product->setIngredientsFromPalmOilN($product['ingredients_from_palm_oil_n']);
    $product->setIngredientsThatMayBeFromPalmOilN($product['ingredients_that_may_be_from_palm_oil_n']);

    $this->em->persist($product);


    /**
     * Create new ADDITIVES
     * @var Additives $additive
     */
    $additive->setAdditiveFr($row['additives_fr']);

    $this->em->persist($additive);
    //Add the additive at list additives to product
    $product->addAdditive($additive);


    /**
     * Create new BRANDS
     * @var Brands $brand
     */
    $brand->setBrand($row['brands']);
    $brand->setBrandTags($row['brands_tags']);

    $this->em->persist($brand);

    $product->setBrand($brand);


    /**
     * Create new COUNTRIES
     * @var Countries $country
     */
    $country->setCountryFr($row['countries_fr']);

    $this->em->persist($country);

    $product->setCountry($country);


    /**
     * Create new INGREDIENTS
     * @var Ingredients $ingredient
     */
    $ingredient->setIngredient($row['ingredients_text']);

    $this->em->persist($ingredient);
    //Add the ingredient at list ingredients to product
    $product->addIngredient($ingredient);


    /**
     * Create new NUTRIONAL_INFORMATION
     * @var NutritionalInformation $nutritional_information
     */
    $nutritional_information->setNutritionGradeFr($row['nutrition_grade_fr']);
    $nutritional_information->setEnergy100g($row['energy_100g']);
    $nutritional_information->setFat100g($row['fat_100g']);
    $nutritional_information->setSaturatedFat100g($row['saturated-fat_100g']);
    $nutritional_information->setCholesterol100g($row['cholesterol_100g']);
    $nutritional_information->setCarbohydrates100g($row['carbohydrates_100g']);
    $nutritional_information->setSugars100g($row['sugars_100g']);
    $nutritional_information->setFiber100g($row['fiber_100g']);
    $nutritional_information->setProteins100g($row['proteins_100g']);
    $nutritional_information->setSalt100g($row['salt_100g']);
    $nutritional_information->setSodium100g($row['sodium_100g']);
    $nutritional_information->setVitaminA100g($row['vitamin-a_100g']);
    $nutritional_information->setCalcium100g($row['calcium_100g']);
    $nutritional_information->setIron100g($row['iron_100g']);

    $this->em->persist($nutritional_information);

    $product->setNutritionalInformation($nutritional_information);

    //We flush the product with others entities
    try {
       // ...
       $this->em->flush();
    }
      catch (UniqueConstraintViolationException $e) {
        // ....
    }
  }
}
