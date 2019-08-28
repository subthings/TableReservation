<?php
declare(strict_types=1);

namespace App\Service;

use App\Entity\Cart;
use App\Entity\Dish;
use App\Entity\User;
use App\Repository\LikeRepository;
use Doctrine\ORM\EntityManagerInterface;
use phpDocumentor\Reflection\Types\Integer;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;



class MenuManager
{
    private $entityManager;

    public function __construct(EntityManagerInterface $entityManager)
    {
        $this->entityManager = $entityManager;
    }
}