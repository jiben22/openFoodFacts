<?php

namespace App\Controller;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
/*
use Doctrine\ORM\EntityManager;
use Doctrine\ORM\EntityRepository;
use Doctrine\ORM\Query;
use Doctrine\ORM\QueryBuilder;
*/
use App\Entity\Product;

class SearchProductController extends Controller
{
    public function searchProduct(Request $request)
    {
        //FORM
        $form = $this->getForm();

        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            // $form->getData() holds the submitted values
            // but, the original `$product` variable has also been updated

            //Retrieve data form Field mapped Product
            $product = $form->getData();
            $product_name = $product->getProductName();
            //Normalization for product_name string
            $product_cap = strtolower($product_name);
            $product_cap = ucfirst($product_cap);

            // We call function to make a statement
            //$list_products = $this->search_list_products($product_cap);

            //Retrieve data from field not mapped
            $criteria = $form->get("criteria")->getData();
            $operator = $form->get("operator")->getData();
            $value = $form->get("value")->getData();
            //Normalization for value
            $value_cap = strtolower($value);
            $value_cap = ucfirst($value_cap);

            //We call function to make a statement
            $list_products = $this->search_list_products($product_cap, $criteria, $operator, $value_cap);

            //Redirection ListProductController to display list of products
            //return $this->redirect( $this->generateUrl('sdzblog_voir', array('id' => 5)) );
            return $this->forward('App\Controller\ListProductController::listProduct', array(
              'list_products' => $list_products,
              //'img_small' => $img_small,
          ));
            /*
            return $this->render('products/list.html.twig', array(
                'list_products' => $list_products,
                //'img_small' => $img_small,
            ));
            */
        }

        return $this->render('products/search.html.twig', array(
          'form' => $form->createView(),
      ));
    }

    //Return the fields added in the form to search a product
    //DEV
    public function getForm()
    {
        $product = new Product();

        // We create the form with createFormBuilder
        $form = $this->createFormBuilder($product)
          ->add('product_name', TextType::class, array(
            'label' => 'Nom du produit',
            'required' => false,
          ))

          ->add('criteria', ChoiceType::class, array(
              'label' => false,
              'choices' => $this->getCriteria(),
              'mapped' => false,
          ))
          ->add('operator', ChoiceType::class, array(
              'label' => false,
              'choices' => $this->getOperators(),
              'mapped' => false,
          ))
          ->add('value', TextType::class, array(
              'label' => false,
              'attr' => array(
                  'placeholder' => 'Valeur',
              ),
              'mapped' => false,
          ))

          ->add('save', SubmitType::class, array('label' => 'Rechercher'))
          ->getForm();

        return $form;
    }

    public function getCriteria()
    {
        $list_criteria = array(
            "Générales" => array(
                "Marque" => "brand",
                "Additives" => "additives",
                "Origine des ingrédients" => "country_fr",
            ),
            "Informations nutritionnelles" => array(
                "Repère nutrionnelles" => "nutrition_grade_fr",
                "Matières grasses / Lipides" => "fat_100g",
                "Acides gras saturés" => "saturated_fat_100g",
                "Sucres" => "sugars_100g",
                "Sel" => "salt_100g",
            ),
            "Ingredients" => array(
                "Ingredients" => "ingredient",
            ),
        );

        return $list_criteria;
    }

    //Return list operators corresponding at type of criteria
    public function getOperators()
    {
        $list_operators = $this->getOperatorsType();

        return $list_operators;
    }

    public function getOperatorsType($type = null)
    {
        switch ($type) {
          case 'string': $list_operators = array(
                            null => null,
                            "Contient" => "contain",
                            "Ne contient pas" => "no_contain",
                          );
                          break;
          case 'integer': $list_operators = array(
                            null => null,
                            "Inférieur (<)" => "lt",
                            "Inférieur ou égal (<=)" => "le",
                            "Egal (=)" => "eq",
                            "Supérieur ou égal (>=)" => "ge",
                            "Supérieur (>)" => "gt",
                          );
                          break;
          default: $list_operators = array(
                            null => null,
                            "Contient" => "contain",
                            "Ne contient pas" => "no_contain",
                          );
                          break;
        }

        return $list_operators;
    }


    /*
      public function searchProducts($product_name)
      {
          // Entity Manager
          $em = $this->getDoctrine()->getManager();

          //Limit of results
          $limit = 30;

          // QueryBuilder
          $qb = $em->createQueryBuilder('p')
              ->select('p')
              ->from('App:Product', 'p')
              ->where('p.product_name LIKE :product_name')
              //%*% the name of product must contents the word
              // product_name into the row
              ->setParameter('product_name', '%' . $product_name .'%')
              ->orderBy('p.product_name', 'ASC')
              //TEST
              ->setMaxResults($limit)
              ->getQuery();

          return $list_products = $qb->getResult();
      }*/

    public function searchProducts($product, $criteria, $operator, $value)
    {
        //TEST
        var_dump($operator);
        // Entity Manager
        $em = $this->getDoctrine()->getManager();

        //$criteriaType = $this->getCriteriaType($criteria);

        //Limit of results
        $limit = 30;

        // QueryBuilder
        $qb = $em->createQueryBuilder('p')
          ->select('p')
          ->from('App:Product', 'p')
          ->where('p.product_name LIKE :product_name')
          ->setParameter('product_name', '%' . $product .'%')
          ->orderBy('p.product_name', 'ASC')
          ->setMaxResults($limit)
          ->getQuery();

        return $list_products = $qb->getResult();
    }

    //Add img foreach product contents into the result
    //DEV
    public function addImgProduct()
    {
        //TEST
        // It's necessary to create an array for stockage for products img

        //Recover image for each product
        foreach ($list_products as $key => $product) {
            //Recover code for product to identify the url
            $code = $product->getCode();
            //Recover data in json
            $json = file_get_contents('https://world.openfoodfacts.org/api/v0/product/'. $code .'.json');
            $data_json = json_decode($json, true);

            //TEST
            var_dump($data_json);
            echo '********************************************************************************************';

            if (isset($data_json['product']) && isset($data_json['product']['image_front_url'])) {
                //Recover url for img small
                $img_small = $data_json['product']['image_front_url'];
                //$list_products['img'] = $img_small;
            //Boolean which woudl say if img exist or no
            }
        }
    }
}
