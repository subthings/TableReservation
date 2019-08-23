<?php
declare(strict_types=1);

namespace App\Service;

use App\Entity\Cart;
use App\Entity\Dish;
use App\Entity\User;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;


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

}
