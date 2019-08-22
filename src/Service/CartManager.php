<?php
declare(strict_types=1);

namespace App\Service;

use App\Entity\Cart;
use App\Entity\User;


class CartManager
{
    private $user;

    public function createCart()
    {
        $cart = new Cart();
        $cart->setUser($this->user);
    }

    public function __construct(User $user)
    {
        $this->user = $user;
    }
}
