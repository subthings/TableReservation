<?php
declare(strict_types=1);

namespace App\Controller;

use App\Entity\Dish;
use App\Form\OrderRowType;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;


use App\Service\CartManager;


class DishController extends AbstractController
{
    /**
     * @Route("/show/{id}", name="showDish")
     */
    public function showDish($id, Request $request, CartManager $cartManager): Response
    {
        $dish = $this->getDoctrine()->getRepository(Dish::class)->find($id);
        $user = $this->get('security.token_storage')->getToken()->getUser();
        $cart = $cartManager->getOrCreateCart($user, $dish);
        $orderRow = $cartManager->returnOrderRow($cart, $dish);
        $form = $this->createForm(OrderRowType::class, $orderRow);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager = $this->getDoctrine()->getManager();
            $cartManager->addOrderRowToCart($cart, $orderRow);

            return $this->redirectToRoute('index');
        }

        return $this->render('cart/addRow.html.twig', [
            'controller_name' => 'DishController',
            'form' => $form->createView(),
            'dish' =>$dish,
        ]);
    }


    /**
     * @Route("/show/{id}/like", name="likeDish", methods={"POST"})
     */
    public function toggleDishLike($id): Response
    {
        $dish = $this->getDoctrine()->getRepository(Dish::class)->find($id);
        $dish->setLikes($dish->getLikes()+1);


        return new JsonResponse(['likes' => 6]);
    }
}
