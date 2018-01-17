<?php
// src/Controller/ModifyProductController.php
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


class ModifyProductController extends Controller
{
  public function AddProduct(Request $request)
  {
      //FORM
      $form = $this->getFormAddProduct();

      $form->handleRequest($request);

      if ($form->isSubmitted() && $form->isValid()) {

          //Retrieve data form Field mapped Product
          $data = $form->getData();
          /*
          $product = $data["product"];
          $additives = $data["additives"];
          $brand = $data["brands"];
          $country = $data["country"];
          $ingredients = $data["ingredients"];
          $nutritionalInformation = $data["nutritionalInformation"];

          // We ADD Product in database
          $product_name = $this->addProductInDatabase($product, $additives, $brand, $country, $ingredients, $nutritionalInformation);
          */
          $product_name = $this->addProductInDatabase($data);
          //We retrieve id of this product with her namer
          $id = $this->getProductId($product_name);

          //Redirect to the view with the product added
          return $this->redirect($this->generateUrl('app_product_information', array(
            'id' => $id,
          )
        ));
      }

      return $this->render('products/add.html.twig', array(
        'form' => $form->createView(),
    ));
  }

  public function getProductId($product_name)
  {
      $repository = $this->getDoctrine()->getRepository(Product::class);
      $product = $repository->findOneBy(['product_name' => $product_name]);

      return $product->getId();
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
          'label' => 'Nom du produit *',
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
          'label' => 'Nom des additifs',
          'required' => false,
        ))

        //BRANDS
        ->add('brand', TextType::class, array(
          'label' => 'Marque *',
          'required' => true,
        ))

        //COUNTRIES
        ->add('country_fr', TextType::class, array(
          'label' => 'Pays',
          'required' => false,
        ))

        //INGREDIENTS
        ->add('ingredient', TextType::class, array(
          'label' => 'Ingrédients',
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
          'label' => 'Énergie',
          'scale' => 4,
          'required' => false,
        ))
        ->add('fat_100g', NumberType::class, array(
          'label' => 'Matières grasses',
          'scale' => 4,
          'required' => false,
        ))
        ->add('saturated_fat_100g', NumberType::class, array(
          'label' => 'Acides gras saturés',
          'scale' => 4,
          'required' => false,
        ))
        ->add('cholesterol_100g', NumberType::class, array(
          'label' => 'Cholestérol',
          'scale' => 4,
          'required' => false,
        ))
        ->add('carbohydrates_100g', NumberType::class, array(
          'label' => 'Hydrate de carbone',
          'scale' => 4,
          'required' => false,
        ))
        ->add('sugars_100g', NumberType::class, array(
          'label' => 'Sucres',
          'scale' => 4,
          'required' => false,
        ))
        ->add('fiber_100g', NumberType::class, array(
          'label' => 'Fibres',
          'scale' => 4,
          'required' => false,
        ))
        ->add('proteins_100g', NumberType::class, array(
          'label' => 'Protéines',
          'scale' => 4,
          'required' => false,
        ))
        ->add('salt_100g', NumberType::class, array(
          'label' => 'Sel',
          'scale' => 4,
          'required' => false,
        ))
        ->add('sodium_100g', NumberType::class, array(
          'label' => 'Sodium',
          'scale' => 4,
          'required' => false,
        ))
        ->add('vitamin_a_100g', NumberType::class, array(
          'label' => 'Vitamine A',
          'scale' => 4,
          'required' => false,
        ))
        ->add('calcium_100g', NumberType::class, array(
          'label' => 'Calcium',
          'scale' => 4,
          'required' => false,
        ))
        ->add('iron_100g', NumberType::class, array(
          'label' => 'Fer',
          'scale' => 4,
          'required' => false,
        ))

        ->add('save', SubmitType::class, array('label' => 'Ajouter'))
        ->getForm();

      return $form;
  }

  public function addProductInDatabase($data)
  {
    var_dump($data);
    var_dump($data["product_name"]);


    $em = $this->getDoctrine()->getManager();

    /**
     * Create new PRODUCT
     * @var Product $product
     */
    $product = new Product();
    //Entering data process for product_name (ucfirst)
    $product_cap = strtolower($data["product_name"]);
    $product_cap = ucfirst($product_cap);
    $product->setProductName($product_cap);
    $product->setServingSize($data["serving_size"]);
    //$product->setAdditivesN($product->getAdditivesN());
    $product->setIngredientsFromPalmOilN($data["ingredients_from_palm_oil_n"]);
    $product->setIngredientsThatMayBeFromPalmOilN($data["ingredients_that_may_be_from_palm_oil_n"]);

    $em->persist($product);


    /**
     * Create new ADDITIVES
     * @var Additives $additive
     */
    $additives = new Additives();
    $additives->setAdditiveFr($data["additive_fr"]);

    $em->persist($additives);
    //Add the additive at list additives to product
    $product->addAdditive($additives);


    /**
     * Create new BRANDS
     * @var Brands $brand
     */
    $brand = new Brands();
    $brand->setBrand($data["brand"]);
    //$brand->setBrandTags($data["brand_tags"]);

    $em->persist($brand);

    $product->setBrand($brand);


    /**
     * Create new COUNTRIES
     * @var Countries $country
     */
    $country = new Countries();
    $country->setCountryFr($data["country_fr"]);

    $em->persist($country);

    $product->setCountry($country);


    /**
     * Create new INGREDIENTS
     * @var Ingredients $ingredient
     */
    $ingredients = new Ingredients();
    $ingredients->setIngredient($data["ingredient"]);

    $em->persist($ingredients);
    //Add the ingredient at list ingredients to product
    $product->addIngredient($ingredients);


    /**
     * Create new NUTRIONAL_INFORMATION
     * @var NutritionalInformation $nutritional_information
     */
    $nutritionalInformation = new NutritionalInformation();
    $nutritionalInformation->setNutritionGradeFr($data["nutrition_grade_fr"]);
    $nutritionalInformation->setEnergy100g($data["energy_100g"]);
    $nutritionalInformation->setFat100g($data["fat_100g"]);
    $nutritionalInformation->setSaturatedFat100g($data["saturated_fat_100g"]);
    $nutritionalInformation->setCholesterol100g($data["cholesterol_100g"]);
    $nutritionalInformation->setCarbohydrates100g($data["carbohydrates_100g"]);
    $nutritionalInformation->setSugars100g($data["sugars_100g"]);
    $nutritionalInformation->setFiber100g($data["fiber_100g"]);
    $nutritionalInformation->setProteins100g($data["proteins_100g"]);
    $nutritionalInformation->setSalt100g($data["salt_100g"]);
    $nutritionalInformation->setSodium100g($data["sodium_100g"]);
    $nutritionalInformation->setVitaminA100g($data["vitamin_a_100g"]);
    $nutritionalInformation->setCalcium100g($data["calcium_100g"]);
    $nutritionalInformation->setIron100g($data["iron_100g"]);

    $em->persist($nutritionalInformation);

    $product->setNutritionalInformation($nutritionalInformation);

    //We flush the product with others entities
    try {
       // ...
       $em->flush();
    }
      catch (UniqueConstraintViolationException $e) {
        // ....
    }

    return $product->getProductName();
  }
}
