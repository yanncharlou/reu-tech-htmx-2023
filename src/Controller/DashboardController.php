<?php

namespace App\Controller;

use App\Entity\Product;
use App\Form\ProductType;
use App\Repository\ProductRepository;
use Doctrine\ORM\EntityManagerInterface;
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
            'price_sum' => $productRepository->getPricesSumInCents(),
        ]);
    }

    #[Route('/htmx/search', name: 'app_dashboard_search')]
    public function search (
        ProductRepository $productRepository,
        Request $request,
    ): Response
    {
//        sleep(1);
        return $this->render('dashboard/htmx-responses/search.html.twig', [
            'products' => $productRepository->findByTextSearch($request->query->get('search')),
        ]);
    }

    #[Route('/htmx/edit/{id}', name: 'app_dashboard_edit', methods: ['GET', 'POST'])]
    public function edit(
        Request $request,
        Product $product,
        EntityManagerInterface $entityManager,
        ProductRepository $productRepository,
    ): Response
    {
        $form = $this->createForm(ProductType::class, $product);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager->flush();

            return $this->render('dashboard/htmx-responses/edit_done.html.twig', [
                'product' => $product,
                'form' => $form,
                'price_sum' => $productRepository->getPricesSumInCents(),
            ]);
        }

        return $this->render('dashboard/htmx-responses/edit_form.html.twig', [
            'product' => $product,
            'form' => $form,
        ]);
    }
}
