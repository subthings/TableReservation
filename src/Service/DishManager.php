<?php
declare(strict_types=1);

namespace App\Service;

use App\Entity\Dish;
use App\Repository\LikeRepository;
use Doctrine\ORM\EntityManagerInterface;
use phpDocumentor\Reflection\Types\Integer;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;



class DishManager
{
    public function countlikes(Dish $dish): Integer
    {

    }
}