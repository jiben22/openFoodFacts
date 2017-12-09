<?php
// src/Controller/ProductController.php
namespace App\Controller;

use Symfony\Component\HttpFoundation\Response;
// N'oubliez pas ce use :
use Symfony\Bundle\FrameworkBundle\Controller\Controller;

class ProductController extends Controller
{
    public function information()
    {
        // renders templates/product_information/index.html
        return $this->render('products/information.html.twig');
    }
}
