<?php

namespace App\Controller;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\JsonResponse;

use App\Entity\Additives;
use App\Entity\Brands;
use App\Entity\Countries;
use App\Entity\Ingredients;
use App\Entity\NutritionalInformation;
use App\Entity\Product;

class HomeProductController extends Controller
{
    public function homeProduct(Request $request)
    {
          //We call function to recover last products
          $list_products = $this->homeProducts();

          //Create list of img for products
          $list_img = $this->getImg($list_products);

          //Redirection ListProductController to display list of products
          return $this->forward('App\Controller\ListProductController::listProduct', array(
            'list_products' => $list_products,
            'list_img' => $list_img,
        ));
    }

    public function homeProducts()
    {
        //Limit of results
        $limit = 15;

        // Entity Manager
        $em = $this->getDoctrine()->getManager();

        $qb = $em->createQueryBuilder();
        $qb->select('count(product.id)');
        $qb->from('App:Product','product');
        $count = $qb->getQuery()->getSingleScalarResult();

        //Recover last products !
        $offset = $count - $limit;

        $qb = $em->createQueryBuilder('last_products')
          ->select('p')
          ->from('App:Product', 'p')
          ->orderBy('p.product_name', 'ASC')
          ->setFirstResult($offset)
          ->getQuery();

        return $list_products = $qb->getResult();
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
            if (($data_json['status'] === 1) || ($data_json['status_verbose'] === 'product found')) {
                if (isset($data_json['product']['image_small_url'])) {
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
