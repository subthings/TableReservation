<?php
declare(strict_types=1);

namespace App\Service;

use App\Entity\Order;
use App\Entity\Table;
use App\Entity\User;
use Doctrine\ORM\EntityManagerInterface;

class OrderManager

{
    private $entityManager;

    public function __construct(EntityManagerInterface $entityManager)
    {
        $this->entityManager = $entityManager;
    }

    public function addOrderToExistTable(Order $order, $notPayedOrders)
    {
        $table = $notPayedOrders[0]->getReservedTable();
        $personNumber = $notPayedOrders[0]->getPersonNumber();

        $order->setReservedTable($table);
        $order->setPersonNumber($personNumber);

        $this->entityManager->persist($order);
        $this->entityManager->flush();
    }

    public function addOrderToNewTable(Table $table, Order $order)
    {
        $table->setIsFree(false);
        $order->setReservedTable($table);

        $this->entityManager->persist($table);
        $this->entityManager->persist($order);
        $this->entityManager->flush();
    }

    public function pay($id)
    {
        $user = $this->entityManager->getRepository(User::class)->find($id);
        $notPayedOrders = $this->entityManager->getRepository(Order::class)->findNotPayed($user);

        foreach ($notPayedOrders as $order){
            $order->setPayed(true);
            $table = $order->getReservedTable();
            $table->setIsFree(true);
            $this->entityManager->persist($order);
            $this->entityManager->persist($table);
        }
        $this->entityManager->flush();
    }

    }