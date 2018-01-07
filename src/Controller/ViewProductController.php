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

        // renders templates/product_information/information.html.twig
        return $this->render('products/information.html.twig', array(
            'product' => $product
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
}
