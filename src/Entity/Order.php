<?php
// src/Entity/Order.php
declare(strict_types=1);

namespace App\Entity;

use App\Entity\Traits\IdentityTrait;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;

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
     * @ORM\Column(type="boolean", nullable=true)
     */
    private $payed;

    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\Bill", inversedBy="orders")
     */
    private $bill;

    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\Table")
     */
    private $reservedTable;

    /**
     * @ORM\Column(type="integer")
     */
    private $personNumber;





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

    public function getBill(): ?Bill
    {
        return $this->bill;
    }

    public function setBill(?Bill $bill): self
    {
        $this->bill = $bill;

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

}
