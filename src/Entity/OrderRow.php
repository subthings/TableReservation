<?php
declare(strict_types=1);

namespace App\Entity;

use App\Entity\Traits\IdentityTrait;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * @ORM\Entity(repositoryClass="App\Repository\OrderRowRepository")
 */
class OrderRow
{
    use IdentityTrait;

    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\Dish")
     * @ORM\JoinColumn(nullable=false)
     */
    private $dish;

    /**
     * @ORM\Column(type="integer")
     * @Assert\GreaterThanOrEqual(1)
     */
    private $quantity;

    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\Cart", inversedBy="orderRows",cascade={"persist"})
     */
    private $cart;

    public function __toString()
    {
        return "$this->id $this->dish $this->quantity";
    }

    public function getDish(): ?Dish
    {
        return $this->dish;
    }

    public function setDish(?Dish $dish): self
    {
        $this->dish = $dish;

        return $this;
    }

    public function getQuantity(): ?int
    {
        return $this->quantity;
    }

    public function setQuantity(int $quantity): self
    {
        $this->quantity = $quantity;

        return $this;
    }

    public function getCart(): ?Cart
    {
        return $this->cart;
    }

    public function setCart(Cart $cart): self
    {
        $this->cart = $cart;
        return $this;
    }

}
