<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;

class ListProductController extends Controller
{
    public function listProduct($list_products, $list_img = null)
    {
      return $this->render('products/list.html.twig', array(
        'list_products' => $list_products,
        'list_img' => $list_img,
      ));
    }
}
