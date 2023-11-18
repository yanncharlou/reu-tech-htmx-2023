<?php

namespace App\Controller;

use App\Repository\ProductRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
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

    #[Route('/htmx/search', name: 'app_dashboard_search')]
    public function search (
        ProductRepository $productRepository,
        Request $request,
    ): Response
    {
        sleep(1);
        return $this->render('dashboard/htmx-responses/search.html.twig', [
            'products' => $productRepository->findByTextSearch($request->query->get('search')),
        ]);
    }

}
