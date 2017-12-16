<?php
// src/Controller/ProductController.php
namespace App\Controller;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Doctrine\ORM\EntityManager;
use Doctrine\ORM\EntityRepository;
use Doctrine\ORM\Query;
use Doctrine\ORM\QueryBuilder;
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

        return $product;
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

            //TEST
            // It's necessary to create an array for stockage for products img

            //Recover image for each product
            foreach($list_products as $key => $product)
            {
                //Recover code for product to identify the url
                $code = $product->getCode();
                //Recover data in json
                $json = file_get_contents('https://world.openfoodfacts.org/api/v0/product/'. $code .'.json');
                $data_json = json_decode($json, TRUE);

                //TEST
                var_dump($data_json);
                echo '********************************************************************************************';

                if( isset($data_json['product']) && isset($data_json['product']['image_front_url']) )
                {
                    //Recover url for img small
                    $img_small = $data_json['product']['image_front_url'];
                    //$list_products['img'] = $img_small;
                    //Boolean which woudl say if img exist or no
                }
            }

            return $this->render('products/list.html.twig', array(
                'list_products' => $list_products,
                //'img_small' => $img_small,
            ));
        }


        return $this->render('products/search.html.twig', array(
            'form' => $form->createView(),
        ));
    }

    /**
     * @param $product_name
     * @return Object[]
     */
    public function search_list_products($product_name)
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
    }
}
