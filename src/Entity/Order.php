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
     * @ORM\Column(type="datetime")
     * @Assert\GreaterThanOrEqual("today")
     */
    private $date;

    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\Bill", inversedBy="orders")
     */
    private $bill;

    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\Table")
     * @ORM\Column(name="picked_table")
     */
    private $table;

    public function getUser(): ?User
    {
        return $this->cart->user;
    }

    public function getCart(): Cart
    {
        return $this->cart;
    }

    public function addCart(Cart $cart): self
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

    public function getDate(): ?\DateTimeInterface
    {
        return $this->date;
    }

    public function setDate(\DateTimeInterface $date): self
    {
        $this->date = $date;

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

    public function getTable(): ?Table
    {
        return $this->table;
    }

    public function setTable(?Table $table): self
    {
        $this->table =  $table;
        return $this;
    }
}
