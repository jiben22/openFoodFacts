<?php

namespace App\Controller;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\JsonResponse;

use App\Entity\Product;

class SearchProductController extends Controller
{
    public function searchProduct(Request $request)
    {
        //FORM
        $form = $this->getForm();

        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            //Retrieve data form Field mapped Product
            $product = $form->getData();
            $product_name = $product->getProductName();
            //Normalization for product_name string
            $product_cap = strtolower($product_name);
            $product_cap = ucfirst($product_cap);
            $tb_search = explode(' ', $product_cap);
            //TEST
            //var_dump($tb_search);

            //Retrieve data from field not mapped
            $criteria = $form->get("criteria")->getData();
            $operator = $form->get("operator")->getData();
            $value = $form->get("value")->getData();
            //Normalization for value
            $value_cap = strtolower($value);
            $value_cap = ucfirst($value_cap);

            //We call function to make a statement
            $list_products = $this->searchProducts($tb_search, $criteria, $operator, $value_cap);

            //Create list of img for products
            $list_img = $this->getImg($list_products);

            //Redirection ListProductController to display list of products
            return $this->forward('App\Controller\ListProductController::listProduct', array(
              'list_products' => $list_products,
              'list_img' => $list_img,
          ));
        }

        return $this->render('products/search.html.twig', array(
          'form' => $form->createView(),
      ));
    }

    public function searchProducts($tb_search, $criteria, $operator, $value)
    {
        //TEST
        var_dump($tb_search);
        var_dump($criteria);
        var_dump($operator);
        var_dump($value);


        //split search in differents products
        //add the differents words
        $values_statement = "";
        foreach ($tb_search as $value) {
          $values_statement = $values_statement . '%' . $value;
          //$values_statement = $values_statement . $value;
        }
        $values_statement = $values_statement . '%';
        //var_dump($tb_search);
        //echo $values_statement;

        //Limit of results
        $limit = 15;

        // Entity Manager
        $em = $this->getDoctrine()->getManager();

        // QueryBuilder -> Just ProductName
        if( $value == null && $tb_search[0] === '' )
        {
            /*
            $qb = $em->createQueryBuilder('p')
              ->select('p')
              ->from('App:Product', 'p')
              ->where('p.product_name LIKE :product_name')
              ->setParameter('product_name', '%Crème%')
              //->setParameter('product_name', $values_statement)
              ->orderBy('p.product_name', 'ASC')
              ->setMaxResults($limit)
              ->getQuery();
              */
        }

        $qb = $em->createQueryBuilder('p')
          ->select('p')
          ->from('App:Product', 'p')
          ->where('p.product_name LIKE :product_name')
          ->setParameter('product_name', $values_statement)
          ->orderBy('p.product_name', 'ASC')
          ->setMaxResults($limit)
          ->getQuery();
        

          return $list_products = $qb->getResult();
    }

    //Return the fields added in the form to search a product
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
              'choices' => $this->getOperatorsType('integer'),
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

          default: $list_operators = array(
                            null => null,
                            "Contient" => "contain",
                            "Ne contient pas" => "no_contain",
                          );
                          break;
        }

        return $list_operators;
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
          case 'salt_100g':
              $type = 'integer';
              break;
        }

        return $type;
      }

    public function getAjaxOperators(Request $request)
    {
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

    //Add img foreach product contents into the result (if exist)
    public function getImg($list_products)
    {
        $list_img = null;

        //Recover image for each product
        foreach ($list_products as $key => $product) {
            //Recover code for product to identify the url
            $code = $product->getCode();
            //Recover data in json
            $json = file_get_contents('https://world.openfoodfacts.org/api/v0/product/'. $code .'.json');
            $data_json = json_decode($json, true);

            //Verification if img exists
            if( ($data_json['status'] === 1) || ($data_json['status_verbose'] === 'product found') )
            {
                if( isset($data_json['product']['image_small_url']) )
                {
                    //Add img for this product into list products
                    $list_img['code'] = $code;
                    $list_img[$code]['img'] = $data_json['product']['image_small_url'];
                }
            }
        }

        //Return the list of img product with [code][img]
        return $list_img;
    }
}
