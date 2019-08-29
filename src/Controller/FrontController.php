<?php
// src/Controller/FrontController.php
declare(strict_types=1);

namespace App\Controller;

use App\Entity\Category;
use App\Entity\Dish;
use App\Entity\User;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class FrontController extends AbstractController
{
    /**
     * @Route("/", name="index")
     */
    public function firstPageMenu(): Response
    {
        $user = $this->get('security.token_storage')->getToken()->getUser();
        if ($user instanceof User) {
            $likedDishes = $this->getDoctrine()->getRepository(Dish::class)->getLikedDishes($user);
            return $this->render('front/menuPage.html.twig', [
                'likedDishes' => $likedDishes,

            ]);
        }
        else {
            return $this->render('front/index.html.twig');
        }
    }

    /**
     * @Route("category/{name}", name="categoryMenu")
     */
    public function getCategoryMenu($name):Response
    {
        $category = $this->getDoctrine()->getRepository(Category::class)->findOneBy([
            'name' => $name,
        ]);
        $dishes = $this->getDoctrine()->getRepository(Dish::class)->findBy([
            'category' => $category
        ]);
        return $this->render('front/categoryMenu.html.twig', [
            'controller_name' => 'FrontController',
            'category' => $category,
            'dishes' => $dishes,
    ]);
    }



}
