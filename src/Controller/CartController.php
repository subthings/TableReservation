<?php
declare(strict_types=1);

namespace App\Controller;

use App\Entity\Cart;
use App\Entity\Dish;
use App\Entity\OrderRow;
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

        $orderRow = new OrderRow();
        $orderRow->setDish($dish);

        $form = $this->createForm(OrderRowType::class, $orderRow);

        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->persist($orderRow);
            $em->flush();

            return $this->redirectToRoute('index');

        }

        $user = $this->get('security.token_storage')->getToken()->getUser();

        $cart = $this->getDoctrine()->getRepository(Cart::class)->findBy([
            'user' => $user,
        ]);
        /*
        if (!$cart){
            $cart = new Cart();
            $cart->setUser($user);
        }
        $request->request->get($cart);
        */

        return $this->render('cart/addRow.html.twig', [
            'form'=>$form->createView(),
        ]);
    }

    /**
     * @Route("/showCart/{id}", name="showCart")
     */
    public function showCart($id)
    {
        return $this->render('cart/userCart.twig', [

        ]);
    }
}
