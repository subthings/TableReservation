<?php
declare(strict_types=1);

namespace App\Service;

use App\Entity\Order;

class OrderManager

{
    public function createOrder()
    {

        $order = new Order();
        $order->setCart($cart);
        $user = $cart->getUser();



        $order->setReservedTable($table);
        $order->setPersonNumber($personNumber);

    }

    public function findTable($notPayedOrders){

    }

    public function getOrderRows($orders){
        foreach ($orders as $order){
            $order->getCart->getOrderRows;

        }
    }
}