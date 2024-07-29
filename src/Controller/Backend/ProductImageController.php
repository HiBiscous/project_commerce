<?php

namespace App\Controller\Backend;

use App\Repository\ProductImageRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

#[Route('/admin/product_image', name: 'admin.product_image')]
class ProductImageController extends AbstractController
{
    #[Route('/', name: '.index')]
    public function index(ProductImageRepository $repo): Response
    {
        return $this->render('Backend/Product_image/index.html.twig', [
            'products_images' => $repo->findAll(),
        ]);
    }

    #[Route('/create', name: '.create', methods: ['GET', 'POST'])]
    public function create(): Response|RedirectResponse
    {
    }
}
