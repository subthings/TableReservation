<?php
declare(strict_types=1);

namespace App\Controller;

use App\Entity\Cart;
use App\Entity\Dish;
use App\Entity\Order;
use App\Entity\OrderRow;
use App\Entity\Table;
use App\Entity\TableReservation;
use App\Entity\User;
use App\Form\OrderRowType;
use App\Form\OrderType;
use App\Form\TableReservationType;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Form\Extension\Core\Type\FormType;
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
    public function showCart($id): Response
    {
        $user = $this->getDoctrine()->getRepository(User::class)->find($id);
        $cart = $this->getDoctrine()->getRepository(Cart::class)->findOneBy([
            'user' => $user,
            'isOrdered' => false,
        ]);
        if(!$cart){
            $cart = new Cart();
            $cart->setUser($user);
            return $this->render('cart/emptyCart.html.twig');
        }

        $orderRows = $cart->getOrderRows();
        $totalSum = 0;
        foreach ($orderRows as $orderRow){
            $totalSum += $orderRow->getDish()->getPrice() * $orderRow->getQuantity();
        }
        return $this->render('cart/userCart.html.twig', [
            'cart' => $cart,
            'orderRows' => $orderRows,
            'totalSum' => $totalSum,
        ]);
    }

    /**
     * @Route("/order/{id}", name="order")
    */
    public function makeOrder(Request $request, $id): Response
    {
        $cart= $this->getDoctrine()->getRepository(Cart::class)->find($id);
        $cart->setIsOrdered(true);

        $order = new Order();
        $order->setCart($cart);

        $form = $this->createForm(OrderType::class, $order);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $table = $this->getDoctrine()->getRepository(Table::class)->findFreeTable($order->getPersonNumber());
            if(!$table instanceof Table){
                return $this->render('order/noFreeTables.html.twig', [
                    'personNumber' => $order->getPersonNumber(),
                ]);
            }
            $table->setIsFree(false);
            $order->setReservedTable($table);

            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->persist($table);
            $entityManager->persist($order);
            $entityManager->flush();
            return $this->redirectToRoute('index');
        }


        return $this->render('cart/order.html.twig', [
            'form'=>$form->createView(),
        ]);
    }

}
