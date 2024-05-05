<?php
// src/Controller/HomeController.php

namespace App\Controller;

use App\Repository\CategoryRepository; // Import the CategoryRepository
use App\Repository\ProductRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class HomeController extends AbstractController
{
    #[Route('/', name: 'app_homepage')]
    public function index(ProductRepository $productRepository, CategoryRepository $categoryRepository): Response
    {
        $featuredProducts = $productRepository->findFeaturedProducts();
        $categories = $categoryRepository->findAll(); // Fetch all categories

        return $this->render('home/index.html.twig', [
            'featuredProducts' => $featuredProducts,
            'categories' => $categories, // Pass the categories to the template
        ]);
    }
}
