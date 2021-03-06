<?php
// src/Entity/Order.php
declare(strict_types=1);

namespace App\Entity;

use App\Entity\Traits\IdentityTrait;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass="App\Repository\OrderRepository")
 * @ORM\Table(name="orders")
 */
class Order
{
    use IdentityTrait;

    /**
     * @ORM\OneToOne(targetEntity="App\Entity\Cart")
     */
    private $cart;

    /**
     * @ORM\Column(type="boolean")
     */
    private $payed = false;


    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\Table")
     */
    private $reservedTable;

    /**
     * @ORM\Column(type="integer")
     */
    private $personNumber;

    /**
     * @ORM\Column(type="datetime")
     */
    private $time;

    public function __construct()
    {
        $this->time = new \DateTime('+7 hours');
    }

    public function getUser(): ?User
    {
        return $this->cart->user;
    }


    public function getCart(): Cart
    {
        return $this->cart;
    }

    public function setCart(Cart $cart): self
    {
        $this->cart = $cart;

        return $this;
    }

    public function getPayed(): ?bool
    {
        return $this->payed;
    }

    public function setPayed(?bool $payed): self
    {
        $this->payed = $payed;

        return $this;
    }


    public function getReservedTable(): ?Table
    {
        return $this->reservedTable;
    }

    public function setReservedTable(?Table $reservedTable): self
    {
        $this->reservedTable = $reservedTable;

        return $this;
    }

    public function getPersonNumber(): ?int
    {
        return $this->personNumber;
    }

    public function setPersonNumber(int $personNumber): self
    {
        $this->personNumber = $personNumber;

        return $this;
    }

    public function getTime(): ?\DateTimeInterface
    {
        return $this->time;
    }

    public function setTime(\DateTimeInterface $time): self
    {
        $this->time = $time;

        return $this;
    }

}
