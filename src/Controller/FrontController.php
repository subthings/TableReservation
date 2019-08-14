<?php
// src/Controller/FrontController.php
declare(strict_types=1);

namespace App\Controller;

use App\Entity\Category;
use App\Entity\Dish;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class FrontController extends AbstractController
{
    /**
     * @Route("/", name="index")
     */
    public function index():Response
    {
        $categories = $this->getDoctrine()->getRepository(Category::class)->findAll();
        $dishes = $this->getDoctrine()->getRepository(Dish::class)->findAll();

        return $this->render('front/index.html.twig', [
            'controller_name' => 'FrontController',
            'categories' => $categories,
        ]);
    }

    /*
     * @Route("/{category}", name="category_menu")

    public function categoryMenu(Request $request, $id)
    {
        $dishes = $this->getDoctrine()->getRepository(Dish::class)->find($id);
    }
*/
}
