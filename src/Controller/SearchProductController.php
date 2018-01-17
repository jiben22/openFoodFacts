<?php

namespace App\Controller;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Response;
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


            //Retrieve data from field not mapped
            //var_dump($form->getData());
            $criteria = $form->get("criteria")->getData();
            //var_dump($criteria);
            $operator = $form->get("operator")->getData();
            //var_dump($operator);
            $value = $form->get("value")->getData();
            //Normalization for value
            $value_cap = strtolower($value);
            $value_cap = ucfirst($value_cap);

            //We call function to make a statement
            $list_products = $this->searchProducts($product_cap, $criteria, $operator, $value_cap);

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
              'choices' => $this->getOperatorsType('string'),
              'mapped' => false,
          ))
          ->add('value', TextType::class, array(
              'label' => false,
              'attr' => array(
                  'placeholder' => 'Valeur',
              ),
              'required' => false,
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

    public function getOperatorsType($type)
    {
        switch ($type) {
          case 'string': $list_operators = array(
                            "Contient" => "contain",
                            "Ne contient pas" => "no_contain",
                          );
                          break;
          case 'integer': $list_operators = array(
                            "Inférieur (<)" => "lt",
                            "Inférieur ou égal (<=)" => "le",
                            "Egal (=)" => "eq",
                            "Supérieur ou égal (>=)" => "ge",
                            "Supérieur (>)" => "gt",
                          );
                          break;

                        case 'OK':
                        $list_operators = array(
                                          "OK" => "OK",
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

    public function getEntityCriteria($criteria)
    {
      switch ($criteria) {
          case 'additives':
              $entity = 'Additives';
              break;
          case 'brand':
              $entity = 'Brands';
              break;
          case 'country_fr':
              $entity = 'Countries';
              break;
          case 'ingredient':
              $entity = 'Ingredients';
              break;
          case 'nutrition_grade_fr':
          case 'fat_100g':
          case 'saturated_fat_100g':
          case 'sugars_100g':
              $entity = 'NutritionalInformation';
              break;
          /*
          case null:
              $type = 'string';
              break;
          default:
              $type = 'integer';
              break;
          */
        }

        return $entity;
    }

    public function searchProducts($product, $criteria, $operator, $value)
    {
        //TEST
        //var_dump($product);
        //var_dump($criteria);
        //var_dump($operator);
        //var_dump($value);

        // Entity Manager
        $em = $this->getDoctrine()->getManager();

        //We retrieve the entity of criteria
        $entity = $this->getEntityCriteria($criteria);
        //We retrieve type of criteria
        $type = $this->getCriteriaType($criteria);
        //We retrieve the operator sql
        //var_dump($type);
        $operator_sql = $this->getStatementType($type, $operator);

        //Limit of results
        $limit = 30;

        //TEST
        var_dump($criteria);
        var_dump($operator_sql);
        var_dump($value);

        // QueryBuilder
        $qb = $em->createQueryBuilder('p')
          ->select('p')
          //->select('p', 'other')
          ->from('App:Product', 'p')
          //->leftJoin("App:" . $entity, 'other')
          ->where('p.product_name LIKE :product_name')
          //->andWhere('other.' . $criteria . ' ' . $operator_sql . ' ' . $value)
          ->setParameter('product_name', '%' . $product .'%')
          ->orderBy('p.product_name', 'ASC')
          ->setMaxResults($limit)
          ->getQuery();

        return $list_products = $qb->getResult();
    }

    //Return the type of criteria selected
    public function getCriteriaType($criteria)
    {
        switch ($criteria) {
          case 'brand':
          case 'additives':
          case 'country_fr':
          case 'nutrition_grade_fr':
          case 'ingredient':
              $type = 'string';
              break;
          case 'fat_100g':
          case 'saturated_fat_100g':
          case 'sugars_100g':
              $type = 'integer';
              break;
          /*
          case null:
              $type = 'string';
              break;
          default:
              $type = 'integer';
              break;
          */
        }

        return $type;
      }

    public function getAjaxOperators(Request $request)
    {
        //Problem HERE ! Not retrieve POST['criteria']
        $criteria = $request->request->get('criteria');
        // Retrieve type of criteria
        $type = $this->getCriteriaType($criteria);
        // By type of criteria, we retrieve list of operators
        $list_operators = $this->getOperatorsType($type);

        return new JsonResponse($list_operators);
    }

    //Returns the operator_sql by type of criteria
    public function getStatementType($type, $operator)
    {
        if($type == 'string')
        {
          switch ($operator) {
            case 'contain':
              $operator_sql = 'LIKE ';
              break;
            case 'no_contain':
              $operator_sql = 'NOT LIKE ';
              break;
          }
        }
        else if($type == 'integer')
        {
          switch ($operator) {
            case 'lt':
              $operator_sql = '<';
              break;
            case 'le':
              $operator_sql = '<=';
              break;
            case 'eq':
              $operator_sql = '=';
              break;
            case 'ge':
              $operator_sql = '>=';
              break;
            case 'gt':
              $operator_sql = '>';
              break;
          }
        }

        return $operator_sql;
    }
    //Add img foreach product contents into the result
    //DEV
    /*
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
    */
}
