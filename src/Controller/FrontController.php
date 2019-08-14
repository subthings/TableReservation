<?php
// src/Controller/FrontController.php
declare(strict_types=1);

namespace App\Controller;

use App\Entity\Category;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;

class FrontController extends AbstractController
{
    /**
     * @Route("/", name="index")
     */
    public function index()
    {
        $categories = $this->getDoctrine()->getRepository(Category::class)->findAll();
        return $this->render('front/index.html.twig', [
            'controller_name' => 'FrontController',
            'categories' => $categories,
        ]);
    }
}
