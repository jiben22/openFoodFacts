<?php
// src/Controller/AddProductController.php
namespace App\Controller;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;


class AddProductController extends Controller
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

    public function search(Request $request)
    {
        $product = new Product();

        // We create the form with createFormBuilder
        $form = $this->createFormBuilder($product)
            ->add('product_name', TextType::class, array('label' => 'Nom du produit'))
            ->add('save', SubmitType::class, array('label' => 'Rechercher'))
            ->getForm();

        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            // $form->getData() holds the submitted values
            // but, the original `$product` variable has also been updated
            $product = $form->getData();
            $product_name = $product->getProductName();

            $product_cap = strtolower($product_name);
            $product_cap = ucfirst($product_cap);

            // We call function to make a statement
            $list_products = $this->search_list_products($product_cap);
            

            return $this->render('products/list.html.twig', array(
                'list_products' => $list_products,
                //'img_small' => $img_small,
            ));
        }


        return $this->render('products/search.html.twig', array(
            'form' => $form->createView(),
        ));
    }
}
