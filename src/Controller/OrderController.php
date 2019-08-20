<?php
declare(strict_types=1);

namespace App\Controller;

use App\Entity\Order;
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
        $notPayedOrders = $this->getDoctrine()->getRepository(Order::class)->findNotPayed();

        return $this->render('order/list.html.twig', [
            'controller_name' => 'OrderTypeController',
            'user' => $user,
            'notPayedOrders' => $notPayedOrders,
        ]);
    }
}
