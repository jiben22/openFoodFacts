<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;

class ListProductController extends Controller
{
    public function listProduct($list_products)
    {
      return $this->render('products/list.html.twig', array(
          'list_products' => $list_products,
          //'img_small' => $img_small,
      ));
    }
}
