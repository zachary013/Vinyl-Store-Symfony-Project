<?php
// src/Controller/AdminController.php

namespace App\Controller;

use App\Entity\User;
use App\Entity\Product;
use App\Entity\Category;
use App\Form\UserType;
use App\Form\ProductType;
use App\Form\CategoryType;
use Doctrine\ORM\EntityManagerInterface; // Import EntityManagerInterface
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Security\Core\Exception\AccessDeniedException;

class AdminController extends AbstractController
{
    private $entityManager;

    public function __construct(EntityManagerInterface $entityManager)
    {
        $this->entityManager = $entityManager;
    }

    /**
     * @Route("/admin/dashboard", name="admin_dashboard")
     */
    public function adminDashboard(): Response
    {
        // Check if the current user has ROLE_ADMIN
        $this->denyAccessUnlessGranted('ROLE_ADMIN');

        // Optionally, you can provide a custom message if access is denied
        // $this->denyAccessUnlessGranted('ROLE_ADMIN', null, 'User tried to access a page without having ROLE_ADMIN');

        // If access is granted, render the admin dashboard
        return $this->render('admin/dashboard.html.twig');
    }

    /**
     * @Route("/admin/users", name="admin_users")
     */
    public function manageUsers(): Response
    {
        $userRepository = $this->entityManager->getRepository(User::class);
        $users = $userRepository->findAll();

        return $this->render('admin/users.html.twig', [
            'users' => $users,
        ]);
    }

    /**
     * @Route("/admin/user/{id}/edit", name="admin_user_edit")
     */
    public function editUser(User $user, Request $request): Response
    {
        $form = $this->createForm(UserType::class, $user);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $this->entityManager->flush();

            $this->addFlash('success', 'User updated successfully');

            return $this->redirectToRoute('admin_users');
        }

        return $this->render('admin/user_edit.html.twig', [
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/admin/products", name="admin_products")
     */
    public function manageProducts(): Response
    {
        $productRepository = $this->entityManager->getRepository(Product::class);
        $products = $productRepository->findAll();

        return $this->render('admin/products.html.twig', [
            'products' => $products,
        ]);
    }

    /**
     * @Route("/admin/product/{id}/edit", name="admin_product_edit")
     */
    public function editProduct(Product $product, Request $request): Response
    {
        $form = $this->createForm(ProductType::class, $product);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $this->entityManager->flush();

            $this->addFlash('success', 'Product updated successfully');

            return $this->redirectToRoute('admin_products');
        }

        return $this->render('admin/product_edit.html.twig', [
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/admin/categories", name="admin_categories")
     */
    public function manageCategories(): Response
    {
        $categoryRepository = $this->entityManager->getRepository(Category::class);
        $categories = $categoryRepository->findAll();

        return $this->render('admin/categories.html.twig', [
            'categories' => $categories,
        ]);
    }

    /**
     * @Route("/admin/category/{id}/edit", name="admin_category_edit")
     */
    public function editCategory(Category $category, Request $request): Response
    {
        $form = $this->createForm(CategoryType::class, $category);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $this->entityManager->flush();

            $this->addFlash('success', 'Category updated successfully');

            return $this->redirectToRoute('admin_categories');
        }

        return $this->render('admin/category_edit.html.twig', [
            'form' => $form->createView(),
        ]);
    }
}
