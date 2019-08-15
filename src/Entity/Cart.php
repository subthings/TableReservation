<?php
// src/Entity/Cart.php
declare(strict_types=1);

namespace App\Entity;

use App\Entity\Traits\IdentityTrait;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;

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
     * @ORM\OneToMany(targetEntity="App\Entity\OrderRow", mappedBy="cart")
     */
    private $orderRows;

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


    public function getOrderRows(): Collection
    {
        return $this->orderRows;
    }

    public function addOrderRows(OrderRow $orderRow): self
    {
        if (!$this->orderRows->contains($orderRow)) {
            $this->orderRows[] = $orderRow;
        }

        return $this;
    }

    public function removeOrderRows(Dish $orderRow): self
    {
        if ($this->orderRows->contains($orderRow)) {
            $this->orderRows->removeElement($orderRow);
        }
        return $this;
    }

}
