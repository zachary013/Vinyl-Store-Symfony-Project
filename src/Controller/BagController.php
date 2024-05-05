<?php

// src/Controller/BagController.php

namespace App\Controller;

use App\Entity\Product;
use App\Entity\User;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class BagController extends AbstractController
{
    private EntityManagerInterface $entityManager;

    public function __construct(EntityManagerInterface $entityManager)
    {
        $this->entityManager = $entityManager;
    }

    /**
     * @Route("/bag/add/{productId}", name="bag_add")
     */
    public function addToBag(Product $product): RedirectResponse
    {
        /** @var User|null $user */
        $user = $this->getUser();

        if (!$user) {
            // Handle case where user is not authenticated (e.g., redirect to login)
            return $this->redirectToRoute('app_login');
        }

        $user->addToBag($product);

        $this->entityManager->flush();

        return $this->redirectToRoute('product_details', ['id' => $product->getId()]);
    }

    /**
     * @Route("/bag/remove/{productId}", name="bag_remove")
     */
    public function removeFromBag(Product $product): RedirectResponse
    {
        /** @var User|null $user */
        $user = $this->getUser();

        if (!$user) {
            // Handle case where user is not authenticated (e.g., redirect to login)
            return $this->redirectToRoute('app_login');
        }

        $user->removeFromBag($product);

        $this->entityManager->flush();

        return $this->redirectToRoute('view_bag');
    }

    /**
     * @Route("/bag", name="view_bag")
     */
    public function viewBag(): Response
    {
        /** @var User|null $user */
        $user = $this->getUser();

        if (!$user) {
            // Handle case where user is not authenticated (e.g., redirect to login)
            return $this->redirectToRoute('app_login');
        }

        $bagContents = $user->getBag();

        return $this->render('bag/view.html.twig', [
            'bagContents' => $bagContents,
        ]);
    }
}
