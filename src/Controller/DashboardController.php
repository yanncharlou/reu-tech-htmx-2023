<?php

namespace App\Controller;

use App\Repository\ProductRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class DashboardController extends AbstractController
{
    #[Route('/', name: 'app_dashboard')]
    public function index(
        ProductRepository $productRepository
    ): Response
    {
        return $this->render('dashboard/index.html.twig', [
            'products' => $productRepository->findAll(),
        ]);
    }
}
