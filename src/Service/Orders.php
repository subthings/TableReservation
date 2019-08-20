<?php
declare(strict_types=1);

namespace App\Service;

class Orders
{
    public function getOrderRows($orders){
        foreach ($orders as $order){
            $order->getCart->getOrderRows;

        }
    }
}