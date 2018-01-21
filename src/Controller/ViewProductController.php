<?php

namespace App\Controller;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;

class ViewProductController extends Controller
{
    public function viewProduct(Request $request)
    {
        // We retrieve our id route parameter
        $id = $request->attributes->get('id');
        // We retrieve data product
        $product = $this->getProduct($id);
        //Get img for product if exists
        $img = $this->getImg($product);

        // renders templates/product_information/information.html.twig
        return $this->render('products/view.html.twig', array(
            'product' => $product,
            'img' => $img,
        ));
    }

    public function getProduct($id)
    {
        // Retrieve product with his id
        $product = $this->getDoctrine()
            ->getRepository('App:Product')
            ->find($id);

        // Verification if the product exist
        if (!$product) {
            throw $this->createNotFoundException(
                'Pas de produit pour cet id '.$id
            );
        }

        return $product;
    }

    public function getImg($product)
    {
        $img = null;

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
                $img = $data_json['product']['image_small_url'];
            }
        }

        //Return img
        return $img;
    }
}
