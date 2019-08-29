<?php
// src/Entity/User.php
declare(strict_types=1);

namespace App\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use FOS\UserBundle\Model\User as BaseUser;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * @ORM\Entity
 * @ORM\Table(name="fos_user")
 */
class User extends BaseUser
{
    /**
     * @ORM\Id
     * @ORM\Column(type="integer")
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    protected $id;

    /**
     * @ORM\OneToMany(targetEntity="App\Entity\Cart", mappedBy="user", orphanRemoval=true)
     */
    private $carts;

    public function __construct()
    {
        parent::__construct();
        $this->carts = new ArrayCollection();
    }


    /**
     * @return Collection|Order[]
     */
    public function getCart(): ?Cart
    {
        return $this->carts;
    }

    public function addCart(Cart $cart): self
    {
        if (!$this->carts->contains($cart)) {
            $this->carts[] = $cart;
            $cart->setUser($this);
        }

return $this;
    }

    public function removeCarts(Cart $cart): self
    {
        if ($this->carts->contains($cart)) {
            $this->carts->removeElement($cart);
            if ($cart->getUser() === $this) {
                $cart->setUser(null);
            }
        }

        return $this;
    }

}