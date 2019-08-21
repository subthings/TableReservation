<?php
declare(strict_types=1);

namespace App\Controller;

use App\Entity\Cart;
use App\Entity\Order;
use App\Entity\Table;
use App\Entity\User;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;

class OrderController extends AbstractController
{
    /**
     * @Route("/orders/{id}", name="ordersList")
     */
    public function index($id)
    {
        $user = $this->getDoctrine()->getRepository(User::class)->find($id);
        $notPayedOrders = $this->getDoctrine()->getRepository(Order::class)->findNotPayed($user);
        $carts = $this->getDoctrine()->getRepository(Cart::class)->findBy([
            'user' => $user,
        ]);
        /*
        $notPayedOrders =[];
        foreach ($carts as $cart) {
            $notPayedOrders[] = $this->getDoctrine()->getRepository(Order::class)->findBy([
                'payed' => false,
                'cart' => $cart,
            ]);
        }*/
        return $this->render('order/list.html.twig', [
            'controller_name' => 'OrderTypeController',
            'user' => $user,
            'notPayedOrders' => $notPayedOrders,
        ]);
    }

    /**
     * @Route("/orders/{id}/pay", name="pay")
     */
    public function pay($id)
    {
        $user = $this->getDoctrine()->getRepository(User::class)->find($id);
        $notPayedOrders = $this->getDoctrine()->getRepository(Order::class)->findNotPayed($user);
        $em = $this->getDoctrine()->getManager();
        foreach ($notPayedOrders as $order){
            $order->setPayed(true);
            $table = $order->getReservedTable();
            $table->setIsFree(true);
            $em->persist($order);
            $em->persist($table);
        }
        $em->flush();
        return $this->redirectToRoute('index');
        //free table, payed order
    }
}
