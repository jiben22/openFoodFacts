<?php
// src/Controller/ProductController.php
namespace App\Controller;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use App\Entity\Product;

class ProductController extends Controller
{
    public function information(Request $request)
    {
        // We retrieve our id route parameter
        $id = $request->attributes->get('id');
        // We retrieve data product
        $product = $this->data_product($id);

        // renders templates/product_information/information.html.twig
        return $this->render('products/information.html.twig', array(
            'product' => $product
        ));
    }

    public function data_product($id)
    {
        $product = $this->getDoctrine()
            ->getRepository(Product::class)
            ->find($id);

        if (!$product) {
            throw $this->createNotFoundException(
                'Pas de produit pour cet id '.$id
            );
        }

        return new JsonResponse($product);
    }
}
