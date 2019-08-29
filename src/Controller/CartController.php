<?php
declare(strict_types=1);

namespace App\Controller;


use App\Entity\Cart;
use App\Entity\User;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;


class CartController extends AbstractController
{
    /**
     * @Route("/showCart/{id}", name="showCart")
     */
    public function showCart($id): Response
    {
        $user = $this->getDoctrine()->getRepository(User::class)->find($id);
        $cart = $this->getDoctrine()->getRepository(Cart::class)->findOneBy([
            'user' => $user,
            'isOrdered' => false,
        ]);
        if (!$cart) {
            $cart = new Cart();
            $cart->setUser($user);
            return $this->render('cart/emptyCart.html.twig');
        }

        $orderRows = $cart->getOrderRows();
        $totalSum = 0;
        foreach ($orderRows as $orderRow) {
            if (!$orderRow->getDish()){
                return $this->render('front/emergencyPage.html.twig', [
                    'message' => 'There is a dish that has been deleted in your cart.'
                ]);
            }
            else {
                $totalSum += $orderRow->getDish()->getPrice() * $orderRow->getQuantity();
            }
        }
        return $this->render('cart/userCart.html.twig', [
            'cart' => $cart,
            'orderRows' => $orderRows,
            'totalSum' => $totalSum,
        ]);
    }

}
