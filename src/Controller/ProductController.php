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

        return $product;
    }

    //Function temporaire to create a entity
    public function createEntity()
    {
        // Création de l'entité
        $product = new Product();
        $product->setUrl('http://world-fr.openfoodfacts.org/produit/0000000001663/creme-dessert-chocolat-ferme-de-la-fremondiere');
        //$product->setLastModifiedDatetime('Alexandre');
        $product->setProductName("Crème dessert chocolat");
        $product->setServingSize("28 g (1 ONZ)");
        $product->setIngredientsFromPalmOil(0);
        $product->setIngredientsThatMayBeFromPalmOil(0);

        // On peut ne pas définir ni la date ni la publication,
        // car ces attributs sont définis automatiquement dans le constructeur

        // On récupère l'EntityManager
        $em = $this->getDoctrine()->getManager();

        // Étape 1 : On « persiste » l'entité
        $em->persist($product);

        // Étape 2 : On « flush » tout ce qui a été persisté avant
        $em->flush();
    }


    public function search()
    {
        return $this->render('products/search.html.twig');
    }

    public function form_search()
    {
        $form = $this->createFormBuilder($task)
            ->add('product_name', TextType::class)
            ->add('save', SubmitType::class, array('label' => 'Rechercher'))
            ->getForm();
    }
}
