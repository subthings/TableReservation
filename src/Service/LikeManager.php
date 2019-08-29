<?php
declare(strict_types=1);

namespace App\Service;

use App\Entity\Dish;
use App\Entity\Like;
use App\Entity\User;
use Doctrine\ORM\EntityManagerInterface;



class LikeManager
{
    private $entityManager;

    public function __construct(EntityManagerInterface $entityManager)
    {
        $this->entityManager = $entityManager;
    }

    public function pressLike($id, User $user)
    {
        $dish = $this->entityManager->getRepository(Dish::class)->find($id);
        $like = $this->entityManager->getRepository(Like::class)->findOneBy([
            'user' => $user,
            'dish' => $dish,
        ]);

        if (isset($like)){
            $this->entityManager->remove($like);
        }
        else {
            $like = new Like();
            $like->setUser($user);
            $like->setDish($dish);
            $this->entityManager->persist($like);
        }
        $this->entityManager->flush();

        $likes = $this->entityManager->getRepository(Like::class)->findBy([
            'dish' => $dish,
        ]);

        return $likes;

    }
}