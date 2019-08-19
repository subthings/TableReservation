<?php

namespace App\Controller;

use App\Entity\Category;
use App\Entity\Dish;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;

class NavbarController extends AbstractController
{
    /**
     * @Route("/navbar", name="navbar")
     */
    public function navbarShow()
    {
        $categories = $this->getDoctrine()->getRepository(Category::class)->findAll();
        $dishes = $this->getDoctrine()->getRepository(Dish::class)->findAll();
        $user = $this->get('security.token_storage')->getToken()->getUser();

        return $this->render('navbar/index.html.twig', [
            'controller_name' => 'NavbarController',
            'categories' => $categories,
            'user' => $user,
        ]);
    }
}
