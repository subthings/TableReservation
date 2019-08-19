<?php
// src/Controller/FrontController.php
declare(strict_types=1);

namespace App\Controller;

use App\Entity\Category;
use App\Entity\Dish;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class FrontController extends AbstractController
{
    /**
     * @Route("/", name="index")
     */
    public function index():Response
    {
        $dishes = $this->getDoctrine()->getRepository(Dish::class)->findAll();

        return $this->render('front/index.html.twig', [
            'controller_name' => 'FrontController',
            'dishes' => $dishes,
        ]);
    }

    /**
     * @Route("category/{id}", name="categoryMenu")
     */
    public function getCategoryMenu($id):Response
    {
        $caregories = $this->getDoctrine()->getRepository(Category::class)->findAll();
        $category = $this->getDoctrine()->getRepository(Category::class)->find($id);
        $dishes = $this->getDoctrine()->getRepository(Dish::class)->findBy([
            'category' => $category
        ]);
        return $this->render('front/categoryMenu.html.twig', [
            'controller_name' => 'FrontController',
            'categories' => $caregories,
            'category' => $category,
            'dishes' => $dishes,
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
