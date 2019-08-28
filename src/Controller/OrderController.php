<?php
declare(strict_types=1);

namespace App\Controller;

use App\Entity\Cart;
use App\Entity\Order;
use App\Entity\OrderRow;
use App\Entity\Table;
use App\Entity\User;
use App\Form\OrderType;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class OrderController extends AbstractController
{
    /**
     * @Route("/order/{id}", name="order")
     */
    public function makeOrder(Request $request, $id): Response
    {
        $cart = $this->getDoctrine()->getRepository(Cart::class)->find($id);
        $cart->setIsOrdered(true);

        $order = new Order();
        $order->setCart($cart);
        $user = $cart->getUser();


        $notPayedOrders = $this->getDoctrine()->getRepository(Order::class)->findNotPayed($user);
        if ($notPayedOrders) {
            $table = $notPayedOrders[0]->getReservedTable();
            $personNumber = $notPayedOrders[0]->getPersonNumber();

            $order->setReservedTable($table);
            $order->setPersonNumber($personNumber);

            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->persist($order);
            $entityManager->flush();

        } else {
            $form = $this->createForm(OrderType::class, $order);
            $form->handleRequest($request);

            if ($form->isSubmitted() && $form->isValid()) {
                $table = $this->getDoctrine()->getRepository(Table::class)
                    ->findFreeTable($order->getPersonNumber());
                if (!$table instanceof Table) {
                    return $this->render('order/noFreeTables.html.twig', [
                        'personNumber' => $order->getPersonNumber(),
                    ]);
                }
                $table->setIsFree(false);
                $order->setReservedTable($table);


                $entityManager = $this->getDoctrine()->getManager();
                $entityManager->persist($table);
                $entityManager->persist($order);
                $entityManager->flush();
                return $this->redirectToRoute('index');
            }
            return $this->render('cart/order.html.twig', [
                'form' => $form->createView(),
            ]);
        }
        $this->addFlash(
            'success',
            'Your food\'ll be in 20 minutes!'
        );
        return $this->redirectToRoute('ordersList', [
            'id' => $user->getId(),
        ]);
    }

    /**
     * @Route("/order/{id}/delete", name="orderRowDelete")
     */
    public function deleteOrderRow($id): Response
    {
        $orderRow = $this->getDoctrine()->getRepository(OrderRow::class)->find($id);
        $entityManager = $this->getDoctrine()->getManager();
        if (!$orderRow) {
            throw $this->createNotFoundException(
                'No order row found for id '.$id
            );
        }
        $user = $this->get('security.token_storage')->getToken()->getUser();
        $cart = $this->getDoctrine()->getRepository(Cart::class)->findOneBy([
            'user' => $user,
            'isOrdered' => false,
        ]);

        if (count($cart->getOrderRows()) == 1){

            $entityManager->remove($cart);
        }
        $entityManager->remove($orderRow);
        $entityManager->flush();

        $this->addFlash(
            'success',
            'The dish has been deleted from your cart.'
        );
        return $this->redirectToRoute('showCart',[
            'id' =>$user->getId(),
        ]);
    }


    /**
     * @Route("/orders/{id}", name="ordersList")
     */
    public function showOrders($id)
    {
        $user = $this->getDoctrine()->getRepository(User::class)->find($id);
        $notPayedOrders = $this->getDoctrine()->getRepository(Order::class)->findNotPayed($user);
        $carts = $this->getDoctrine()->getRepository(Cart::class)->findBy([
            'user' => $user,
        ]);


        return $this->render('order/list.html.twig', [
            'controller_name' => 'OrderTypeController',
            'user' => $user,
            'notPayedOrders' => $notPayedOrders,
        ]);
    }

    /**
     * @Route("/orders/{id}/pay", name="pay")
     */
    public function pay($id): Response
    {
        $user = $this->getDoctrine()->getRepository(User::class)->find($id);
        $notPayedOrders = $this->getDoctrine()->getRepository(Order::class)->findNotPayed($user);
        $em = $this->getDoctrine()->getManager();
        foreach ($notPayedOrders as $order){
            $order->setPayed(true);
            $table = $order->getReservedTable();
            $table->setIsFree(true);
            $em->persist($order);
            $em->persist($table);
        }
        $em->flush();
        return $this->redirectToRoute('index');
    }


    /**
     * @param $name
     * @param \Swift_Mailer $mailer
     * @return Response
     * @Route("/send", name="send")
     */
    public function swiftMailer( \Swift_Mailer $mailer): Response
    {
        $message = (new \Swift_Message('Hello Email'))
            ->setFrom('reservationmailer25@gmail.com')
            ->setTo('reservationmailer25@gmail.com')
            ->setBody('You should see me from the profiler!');

        $mailer->send($message);

        return $this->render('front/index.html.twig');
    }
}
