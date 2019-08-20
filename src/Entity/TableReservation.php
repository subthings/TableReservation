<?php
declare(strict_types=1);

namespace App\Entity;

use App\Entity\Traits\IdentityTrait;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * @ORM\Entity(repositoryClass="App\Repository\TableReservationRepository")
 */
class TableReservation
{
    use IdentityTrait;

    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\Table")
     * @ORM\JoinColumn(nullable=false)
     */
    private $pickedTable;

    /**
     * @ORM\Column(type="datetime")
     * @Assert\GreaterThanOrEqual("today")
     */
    private $timeStart;

    /**
     * @ORM\Column(type="datetime")
     */
    private $timeEnd;

    /**
     * @ORM\OneToMany(targetEntity="App\Entity\Order", mappedBy="tableReservation")
     */
    private $orders;

    /**
     * @ORM\Column(type="integer")
     */
    private $quantity;

    public function __construct()
    {
        $this->orders = new ArrayCollection();
    }

    public function getPickedTable(): ?Table
    {
        return $this->pickedTable;
    }

    public function setPickedTable(?Table $pickedTable): self
    {
        $this->pickedTable = $pickedTable;

        return $this;
    }

    public function getTimeStart(): ?\DateTimeInterface
    {
        return $this->timeStart;
    }

    public function setTimeStart(\DateTimeInterface $timeStart): self
    {
        $this->timeStart = $timeStart;

        return $this;
    }

    public function getTimeEnd(): ?\DateTimeInterface
    {
        return $this->timeEnd;
    }

    public function setTimeEnd(\DateTimeInterface $timeEnd): self
    {
        $this->timeEnd = $timeEnd;

        return $this;
    }

    /**
     * @return Collection|Order[]
     */
    public function getOrders(): Collection
    {
        return $this->orders;
    }

    public function addOrder(Order $order): self
    {
        if (!$this->orders->contains($order)) {
            $this->orders[] = $order;
            $order->setTableReservation($this);
        }

        return $this;
    }

    public function removeOrder(Order $order): self
    {
        if ($this->orders->contains($order)) {
            $this->orders->removeElement($order);
            // set the owning side to null (unless already changed)
            if ($order->getTableReservation() === $this) {
                $order->setTableReservation(null);
            }
        }

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
}
