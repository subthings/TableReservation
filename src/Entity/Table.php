<?php
// src/Entity/Table.php
declare(strict_types=1);

namespace App\Entity;

use App\Entity\Traits\IdentityTrait;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * @ORM\Entity(repositoryClass="App\Repository\TableRepository")
  * @ORM\Table(name="tables")
 */
class Table
{
    use IdentityTrait;

    /**
     * @ORM\Column(type="integer")
     */
    private $capacity;


    public function getCapacity(): ?float
    {
        return $this->capacity;
    }

    public function setCapacity(float $capacity): self
    {
        $this->capacity = $capacity;

        return $this;
    }
}
