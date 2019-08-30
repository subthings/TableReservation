<?php
declare(strict_types=1);

namespace App\Service;

use App\Entity\Cart;
use App\Entity\Dish;
use App\Entity\OrderRow;
use App\Entity\User;
use Doctrine\ORM\EntityManagerInterface;


class CartManager
{
    private $entityManager;

    private $cart;

    public function createCart(User $user): ?Cart
    {
        $cart = new Cart();
        $cart->setUser($user);
        return $cart;
    }


    public function __construct(EntityManagerInterface $entityManager)
    {
        $this->entityManager = $entityManager;
        $this->cart = $entityManager->getRepository(Cart::class);
    }

    private function findOrderRowIfExists(Cart $cart, Dish $dish){
        $orderRows = $cart->getOrderRows();
        foreach ($orderRows as $orderRow){
            if ($orderRow->getDish() === $dish){
                return $orderRow;
            }
        }
        return null;
    }

    public function returnOrderRow(Cart $cart, Dish $dish){
        $orderRow = $this->findOrderRowIfExists($cart, $dish);
        if (!isset($orderRow)) {
            $orderRow = new OrderRow();
            $orderRow->setDish($dish);
            $orderRow->setCart($cart);
            $cart->addOrderRow($orderRow);
        }
        return $orderRow;
    }


    public function addOrderRowToCart($cart, $orderRow)
    {
        $entityManager = $this->entityManager;
        $entityManager->persist($orderRow);
        $entityManager->flush();

        $entityManager->persist($cart);
        $entityManager->flush();
    }


    public function getOrCreateCart(User $user, Dish $dish): Cart
    {
        $cart = $this->entityManager->getRepository(Cart::class)->findOneNotOrderedByUser($user);
        if ($cart) {
            $orderRows = $cart->getOrderRows();

            foreach ($orderRows as $orRow) {
                if ($orRow->getDish() == $dish) {
                    $orderRow = $orRow;
                }
            }
        } else {
            $cart = $this->createCart($user);
        }

        return $cart;
    }

    public function deleteOrderRow($id, User $user, OrderRow $orderRow){
        $cart = $this->entityManager->getRepository(Cart::class)->findOneBy([
            'user' => $user,
            'isOrdered' => false,
        ]);

        if (count($cart->getOrderRows()) == 1){

            $this->entityManager->remove($cart);
        }
        $this->entityManager->remove($orderRow);
        $this->entityManager->flush();


    }

}
