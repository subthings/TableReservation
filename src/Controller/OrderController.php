<?php
declare(strict_types=1);

namespace App\Controller;

use App\Entity\Cart;
use App\Entity\Order;
use App\Entity\OrderRow;
use App\Entity\Table;
use App\Entity\User;
use App\Form\OrderType;
use App\Service\CartManager;
use App\Service\OrderManager;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class OrderController extends AbstractController
{
    /**
     * @Route("/order/{id}", name="order")
     */
    public function makeOrder(Request $request, $id, OrderManager $orderManager): Response
    {
        $cart = $this->getDoctrine()->getRepository(Cart::class)->find($id);
        $cart->setIsOrdered(true);

        $order = new Order();
        $order->setCart($cart);
        $user = $cart->getUser();


        $notPayedOrders = $this->getDoctrine()->getRepository(Order::class)->findNotPayed($user);
        if ($notPayedOrders) {
            $orderManager->addOrderToExistTable($order, $notPayedOrders);
        } else {
            $form = $this->createForm(OrderType::class, $order);
            $form->handleRequest($request);

            if ($form->isSubmitted() && $form->isValid()) {
                $table = $this->getDoctrine()->getRepository(Table::class)
                    ->findFreeTable($order->getPersonNumber());
                if (!$table instanceof Table) {
                    return $this->render('order/noFreeTables.html.twig', [
                        'personNumber' => $order->getPersonNumber(),
                    ]);
                }
                $orderManager->addOrderToNewTable($table, $order);

                return $this->redirectToRoute('index');
            }
            return $this->render('cart/order.html.twig', [
                'form' => $form->createView(),
            ]);
        }
        $this->addFlash(
            'success',
            'Your food\'ll be in 20 minutes!'
        );
        return $this->redirectToRoute('ordersList', [
            'id' => $user->getId(),
        ]);
    }

    /**
     * @Route("/order/{id}/delete", name="orderRowDelete")
     */
    public function deleteOrderRow($id, CartManager $cartManager): Response
    {

        $orderRow = $this->getDoctrine()->getRepository(OrderRow::class)->find($id);

        if (!$orderRow) {
            throw $this->createNotFoundException(
                'No order row found for id '.$id
            );
        }
        $user = $this->get('security.token_storage')->getToken()->getUser();
        $cartManager->deleteOrderRow($id, $user, $orderRow);

        $this->addFlash(
            'success',
            'The dish has been deleted from your cart.'
        );
        return $this->redirectToRoute('showCart',[
            'id' =>$user->getId(),
        ]);

    }


    /**
     * @Route("/orders/{id}", name="ordersList")
     */
    public function showOrders($id): Response
    {
        $user = $this->getDoctrine()->getRepository(User::class)->find($id);
        $notPayedOrders = $this->getDoctrine()->getRepository(Order::class)->findNotPayed($user);


        return $this->render('order/list.html.twig', [
            'controller_name' => 'OrderTypeController',
            'user' => $user,
            'notPayedOrders' => $notPayedOrders,
        ]);
    }

    /**
     * @Route("/orders/{id}/pay", name="pay")
     */
    public function pay($id, OrderManager $orderManager): Response
    {
        $orderManager->pay($id);
        return $this->redirectToRoute('index');
    }

}
