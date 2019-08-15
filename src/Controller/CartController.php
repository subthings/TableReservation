<?php
declare(strict_types=1);

namespace App\Controller;

use App\Entity\Dish;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;

class CartController extends AbstractController
{
    /**
     * @Route("/add/cart", name="addToCart")
     */
    public function addToCart($id)
    {
        $dish = $this->getDoctrine()->getRepository(Dish::class)->find($id);


        return $this->render('cart/index.html.twig', [
            'controller_name' => 'CartController',
        ]);
    }
}
