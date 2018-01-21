<?php
// src/Controller/ModifyProductController.php
namespace App\Controller;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
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
  public function ModifyProduct(Request $request)
  {
      //Recover data for product
      $product = $this->getDataProduct($request);
      $additives = $this->getDataAdditives($request);
      $brand = $this->getDataBrand($request);
      $country = $this->getDataCountry($request);
      $ingredients = $this->getDataIngredients($request);
      $nutritionalInformation = $this->getDataNutritionalInformation($request);

      //FORM
      $form = $this->getFormModifyProduct($product, $additives, $brand, $country, $ingredients, $nutritionalInformation);

      $form->handleRequest($request);

      if ($form->isSubmitted() && $form->isValid()) {

          //Retrieve data form Field mapped Product
          $data = $form->getData();

          $product_name = $this->modifyProductInDatabase($data, $product, $additives, $brand, $country, $ingredients, $nutritionalInformation);
          //We retrieve id of this product with her namer
          $id = $this->getProductId($product_name);

          //Redirect to the view with the product added
          return $this->redirect($this->generateUrl('app_product_information', array(
            'id' => $id,
          )
        ));
      }

      return $this->render('products/modify.html.twig', array(
        'form' => $form->createView(),
    ));
  }

  public function getDataProduct(Request $request)
  {
      // We retrieve our id route parameter
      $id = $request->attributes->get('id');

      $repository = $this->getDoctrine()->getRepository(Product::class);
      $product = $repository->findOneBy(array(
        'id' => $id
      ));

      return $product;
  }
  public function getDataAdditives(Request $request)
  {
      // We retrieve our id route parameter
      $id = $request->attributes->get('id');

      $repository = $this->getDoctrine()->getRepository(Additives::class);
      $additives = $repository->findOneBy(array(
        'id' => $id
      ));

      return $additives;
  }
  public function getDataBrand(Request $request)
  {
      // We retrieve our id route parameter
      $id = $request->attributes->get('id');

      $repository = $this->getDoctrine()->getRepository(Brands::class);
      $brand = $repository->findOneBy(array(
        'id' => $id
      ));

      return $brand;
  }
  public function getDataCountry(Request $request)
  {
      // We retrieve our id route parameter
      $id = $request->attributes->get('id');

      $repository = $this->getDoctrine()->getRepository(Countries::class);
      $country = $repository->findOneBy(array(
        'id' => $id
      ));

      return $country;
  }
  public function getDataIngredients(Request $request)
  {
      // We retrieve our id route parameter
      $id = $request->attributes->get('id');

      $repository = $this->getDoctrine()->getRepository(Ingredients::class);
      $ingredients = $repository->findOneBy(array(
        'id' => $id
      ));

      return $ingredients;
  }
  public function getDataNutritionalInformation(Request $request)
  {
      // We retrieve our id route parameter
      $id = $request->attributes->get('id');

      $repository = $this->getDoctrine()->getRepository(NutritionalInformation::class);
      $nutritionalInformation = $repository->findOneBy(array(
        'id' => $id
      ));

      return $nutritionalInformation;
  }

  public function getProductId($product_name)
  {
      $repository = $this->getDoctrine()->getRepository(Product::class);
      $product = $repository->findOneBy(['product_name' => $product_name]);

      return $product->getId();
  }

  //Return the fields added in the form to add a product
  public function getFormModifyProduct($product, $additives, $brand, $country, $ingredients, $nutritionalInformation)
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
          'data' => $product->getProductName(),
          'required' => true,
        ))

        ->add('serving_size', TextType::class, array(
          'label' => 'Portion',
          'data' => $product->getServingSize(),
          'required' => false,
        ))

        ->add('ingredients_from_palm_oil_n', IntegerType::class, array(
          'label' => 'Nombre d\'ingrédients contenant de l\'huile de palme',
          'data' => $product->getIngredientsFromPalmOilN(),
          'required' => false,
        ))

        ->add('ingredients_that_may_be_from_palm_oil_n', IntegerType::class, array(
          'label' => 'Nombre d\'ingrédients pouvant contenir de l\'huile de palme',
          'data' => $product->getIngredientsThatMayBeFromPalmOilN(),
          'required' => false,
        ))

        //ADDITIVES
        ->add('additive_fr', TextareaType::class, array(
          'label' => 'Nom des additifs',
          'data' => $additives->getAdditiveFr(),
          'attr' => array(
            'placeholder' => 'Veuillez mettre une virgule après chaque additif',
            'cols' => '50', 'rows' => '3',
          ),
          'required' => false,
        ))

        //BRANDS
        ->add('brand', TextType::class, array(
          'label' => 'Marque *',
          'data' => $brand->getBrand(),
          'required' => true,
        ))

        //COUNTRIES
        ->add('country_fr', TextType::class, array(
          'label' => 'Pays',
          'data' => $country->getCountryFr(),
          'required' => false,
        ))

        //INGREDIENTS
        ->add('ingredient', TextareaType::class, array(
          'label' => 'Ingrédients',
          'data' => $ingredients->getIngredient(),
          'attr' => array(
            'placeholder' => 'Veuillez mettre une virgule après chaque ingrédient',
            'cols' => '70', 'rows' => '3',
          ),
          'required' => false,
        ))

        //NutritionalInformation
        ->add('nutrition_grade_fr', ChoiceType::class, array(
          'label' => 'Note nutritionnelle',
          'data' => $nutritionalInformation->getNutritionGradeFr(),
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
          'data' => $nutritionalInformation->getEnergy100g(),
          'scale' => 4,
          'required' => false,
        ))
        ->add('fat_100g', NumberType::class, array(
          'label' => 'Matières grasses',
          'data' => $nutritionalInformation->getFat100g(),
          'scale' => 4,
          'required' => false,
        ))
        ->add('saturated_fat_100g', NumberType::class, array(
          'label' => 'Acides gras saturés',
          'data' => $nutritionalInformation->getSaturatedFat100g(),
          'scale' => 4,
          'required' => false,
        ))
        ->add('cholesterol_100g', NumberType::class, array(
          'label' => 'Cholestérol',
          'data' => $nutritionalInformation->getCholesterol100g(),
          'scale' => 4,
          'required' => false,
        ))
        ->add('carbohydrates_100g', NumberType::class, array(
          'label' => 'Hydrate de carbone',
          'data' => $nutritionalInformation->getCarbohydrates100g(),
          'scale' => 4,
          'required' => false,
        ))
        ->add('sugars_100g', NumberType::class, array(
          'label' => 'Sucres',
          'data' => $nutritionalInformation->getSugars100g(),
          'scale' => 4,
          'required' => false,
        ))
        ->add('fiber_100g', NumberType::class, array(
          'label' => 'Fibres',
          'data' => $nutritionalInformation->getFiber100g(),
          'scale' => 4,
          'required' => false,
        ))
        ->add('proteins_100g', NumberType::class, array(
          'label' => 'Protéines',
          'data' => $nutritionalInformation->getProteins100g(),
          'scale' => 4,
          'required' => false,
        ))
        ->add('salt_100g', NumberType::class, array(
          'label' => 'Sel',
          'data' => $nutritionalInformation->getSalt100g(),
          'scale' => 4,
          'required' => false,
        ))
        ->add('sodium_100g', NumberType::class, array(
          'label' => 'Sodium',
          'data' => $nutritionalInformation->getSodium100g(),
          'scale' => 4,
          'required' => false,
        ))
        ->add('vitamin_a_100g', NumberType::class, array(
          'label' => 'Vitamine A',
          'data' => $nutritionalInformation->getVitaminA100g(),
          'scale' => 4,
          'required' => false,
        ))
        ->add('calcium_100g', NumberType::class, array(
          'label' => 'Calcium',
          'data' => $nutritionalInformation->getCalcium100g(),
          'scale' => 4,
          'required' => false,
        ))
        ->add('iron_100g', NumberType::class, array(
          'label' => 'Fer',
          'data' => $nutritionalInformation->getIron100g(),
          'scale' => 4,
          'required' => false,
        ))

        ->add('save', SubmitType::class, array('label' => 'Modifier'))
        ->getForm();

      return $form;
  }

  public function modifyProductInDatabase($data, $product, $additives, $brand, $country, $ingredients, $nutritionalInformation)
  {
    $em = $this->getDoctrine()->getManager();

    /**
     * @var Product $product
     */
    //Entering data process for product_name (ucfirst)
    $product_cap = strtolower($data["product_name"]);
    $product_cap = ucfirst($product_cap);
    $product->setProductName($product_cap);
    $product->setServingSize($data["serving_size"]);
    //$product->setAdditivesN($product->getAdditivesN());
    $product->setIngredientsFromPalmOilN($data["ingredients_from_palm_oil_n"]);
    $product->setIngredientsThatMayBeFromPalmOilN($data["ingredients_that_may_be_from_palm_oil_n"]);

    /**
     * @var Additives $additive
     */
    $additives->setAdditiveFr($data["additive_fr"]);

    //Add the additive at list additives to product
    //$product->addAdditive($additives);


    /**
     * @var Brands $brand
     */
    $brand->setBrand($data["brand"]);
    //$brand->setBrandTags($data["brand_tags"]);

    $product->setBrand($brand);


    /**
     * @var Countries $country
     */
    $country->setCountryFr($data["country_fr"]);

    $product->setCountry($country);


    /**
     * @var Ingredients $ingredient
     */
    $ingredients = new Ingredients();
    $ingredients->setIngredient($data["ingredient"]);

    //Add the ingredient at list ingredients to product
    $product->addIngredient($ingredients);


    /**
     * @var NutritionalInformation $nutritional_information
     */
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

    $product->setNutritionalInformation($nutritionalInformation);

    //We flush the product with others entities
    try {
       // ...
       $em->flush();
    }
      catch (UniqueConstraintViolationException $e) {

    }

    return $product->getProductName();
  }
}
