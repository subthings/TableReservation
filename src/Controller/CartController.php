<?php
declare(strict_types=1);

namespace App\Controller;

use App\Entity\Cart;
use App\Entity\Dish;
use App\Entity\OrderRow;
use App\Entity\User;
use App\Form\OrderRowType;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class CartController extends AbstractController
{
    /**
     * @Route("/add/cart/{id}", name="addToCart")
     */
    public function addToCart(Request $request, $id): Response
    {

        $dish = $this->getDoctrine()->getRepository(Dish::class)->find($id);

        $user = $this->get('security.token_storage')->getToken()->getUser();

        $cart = $this->getDoctrine()->getRepository(Cart::class)->findOneBy([
            'user' => $user,
            'isOrdered' => 0,
        ]);

        if (!$cart){
            $cart = new Cart();
            $cart->setUser($user);
        }

        $orderRow = new OrderRow();
        $orderRow->setDish($dish);
        $orderRow->setCart($cart);

        $cart->addOrderRow($orderRow);

        $form = $this->createForm(OrderRowType::class, $orderRow);

        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->persist($orderRow);
            $entityManager->flush();


            $entityManager->persist($cart);
            $entityManager->flush();

                return $this->redirectToRoute('index');
        }

        return $this->render('cart/addRow.html.twig', [
            'form'=>$form->createView(),
        ]);
    }

    /**
     * @Route("/showCart/{id}", name="showCart")
     */
    public function showCart($id)
    {
        $user = $this->getDoctrine()->getRepository(User::class)->find($id);
        $cart = $this->getDoctrine()->getRepository(Cart::class)->findOneBy([
            'user' => $user,
            'isOrdered' => 0,
        ]);
        $orderRows = $cart->getOrderRows();
        return $this->render('cart/userCart.twig', [
            'cart' => $cart,
            'orderRows' => $orderRows,
        ]);
    }
}
