<?php
declare(strict_types=1);

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass="App\Repository\OrderRowRepository")
 */
class OrderRow
{
    /**
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\Dish")
     * @ORM\JoinColumn(nullable=false)
     */
    private $dish;

    /**
     * @ORM\Column(type="integer")
     */
    private $quanity;

    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\Cart", inversedBy="orderRows",cascade={"persist"})
     */
    private $cart;

    public function __toString()
    {
        return "$this->id $this->dish $this->quanity";
    }

    public function getId(): ?int
    {
        return $this->id;
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

    public function getQuanity(): ?int
    {
        return $this->quanity;
    }

    public function setQuanity(int $quanity): self
    {
        $this->quanity = $quanity;

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
