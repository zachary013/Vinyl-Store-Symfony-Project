<?php

namespace App\Controller;

use App\Entity\OrderDetails;
use App\Form\OrderDetailsType;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

/**
 * @Route("/order-details")
 */
class OrderDetailsController extends AbstractController
{
    private $entityManager;

    public function __construct(EntityManagerInterface $entityManager)
    {
        $this->entityManager = $entityManager;
    }

    /**
     * @Route("/", name="order_details_index", methods={"GET"})
     */
    public function index(): Response
    {
        $orderDetails = $this->entityManager->getRepository(OrderDetails::class)->findAll();

        return $this->render('order_details/index.html.twig', [
            'orderDetails' => $orderDetails,
        ]);
    }

    /**
     * @Route("/new", name="order_details_new", methods={"GET","POST"})
     */
    public function new(Request $request): Response
    {
        $orderDetails = new OrderDetails();
        $form = $this->createForm(OrderDetailsType::class, $orderDetails);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $this->entityManager->persist($orderDetails);
            $this->entityManager->flush();

            return $this->redirectToRoute('order_details_index');
        }

        return $this->render('order_details/new.html.twig', [
            'orderDetails' => $orderDetails,
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/{id}", name="order_details_show", methods={"GET"})
     */
    public function show(OrderDetails $orderDetails): Response
    {
        return $this->render('order_details/show.html.twig', [
            'orderDetails' => $orderDetails,
        ]);
    }

    /**
     * @Route("/{id}/edit", name="order_details_edit", methods={"GET","POST"})
     */
    public function edit(Request $request, OrderDetails $orderDetails): Response
    {
        $form = $this->createForm(OrderDetailsType::class, $orderDetails);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $this->entityManager->flush();

            return $this->redirectToRoute('order_details_index');
        }

        return $this->render('order_details/edit.html.twig', [
            'orderDetails' => $orderDetails,
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/{id}", name="order_details_delete", methods={"POST"})
     */
    public function delete(Request $request, OrderDetails $orderDetails): Response
    {
        if ($this->isCsrfTokenValid('delete'.$orderDetails->getId(), $request->request->get('_token'))) {
            $this->entityManager->remove($orderDetails);
            $this->entityManager->flush();
        }

        return $this->redirectToRoute('order_details_index');
    }
}
