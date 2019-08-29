<?php
// src/Entity/Cart.php
declare(strict_types=1);

namespace App\Entity;

use App\Entity\Traits\IdentityTrait;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass="App\Repository\CartRepository")
 */
class Cart
{
    use IdentityTrait;

    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\User", inversedBy="orders")
     * @ORM\JoinColumn(nullable=false)
     */
    private $user;

    /**
     * @ORM\OneToMany(targetEntity="App\Entity\OrderRow", mappedBy="cart", cascade={"remove"})
     */
    private $orderRows;

    /**
     * @ORM\Column(type="boolean")
     */
    private $isOrdered = false;

    public function __construct()
    {
        $this->orderRows = new ArrayCollection();
    }

    public function getUser(): ?User
    {
        return $this->user;
    }

    public function setUser(User $user): self
    {
        $this->user = $user;

        return $this;
    }

    /**
     * @return Collection|OrderRow[]
     */
    public function getOrderRows(): Collection
    {
        return $this->orderRows;
    }

    public function
    addOrderRow(OrderRow $orderRow): self
    {
        if (!$this->orderRows->contains($orderRow)) {
            $this->orderRows[] = $orderRow;
            $orderRow->setCart($this);
        }

        return $this;
    }

    public function removeOrderRow(OrderRow $orderRow): self
    {
        if ($this->orderRows->contains($orderRow)) {
            $this->orderRows->removeElement($orderRow);

            if ($orderRow->getCart() === $this){
                $orderRow->setCart(null);
            }
        }

        return $this;
    }

    public function getIsOrdered(): ?bool
    {
        return $this->isOrdered;
    }

    public function setIsOrdered(bool $isOrdered): self
    {
        $this->isOrdered = $isOrdered;
        return $this;
    }

}
