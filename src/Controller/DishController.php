<?php
declare(strict_types=1);

namespace App\Controller;

use App\Entity\Dish;
use App\Entity\Like;
use App\Form\OrderRowType;
use App\Service\LikeManager;
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
            $cartManager->addOrderRowToCart($cart, $orderRow);

            return $this->redirectToRoute('index');
        }

        $likes = $this->getDoctrine()->getRepository(Like::class)->findBy([
            'dish' => $dish,
        ]);

        $countLikes = count($likes);

        return $this->render('cart/addRow.html.twig', [
            'controller_name' => 'DishController',
            'form' => $form->createView(),
            'dish' => $dish,
            'likes' => $countLikes,
        ]);
    }


    /**
     * @Route("/show/{id}/like", name="likeDish", methods={"POST"})
     */
    public function toggleDishLike($id, LikeManager $likeManager): Response
    {

        $user = $this->get('security.token_storage')->getToken()->getUser();

        $likes = $likeManager->pressLike($id, $user);
        return new JsonResponse(['likes' => count($likes)]);
    }
}
