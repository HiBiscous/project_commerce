<?php

namespace App\Controller\Backend;

use App\Entity\ProductImage;
use App\Form\ProductImageType;
use Doctrine\ORM\EntityManagerInterface;
use App\Repository\ProductImageRepository;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

#[Route('/admin/productImage', name: 'admin.productImage')]
class ProductImageController extends AbstractController
{
    public function __construct(private EntityManagerInterface $em)
    {
    }
    #[Route('/', name: '.index')]
    public function index(ProductImageRepository $repo): Response
    {
        return $this->render('Backend/ProductImage/index.html.twig', [
            'productsImages' => $repo->findAll(),
        ]);
    }

    #[Route('/create', name: '.create', methods: ['GET', 'POST'])]
    public function create(Request $request): Response|RedirectResponse
    {
        $productImage = new ProductImage;
        $form = $this->createForm(ProductImageType::class, $productImage);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $this->em->persist($productImage);
            $this->em->flush();

            $this->addFlash('success', 'L\'image a bien été créee.');
            return $this->redirectToRoute('admin.productImage.index');
        }

        return $this->render('Backend/Product_image/create.html.twig', [
            'form' => $form
        ]);
    }

    #[Route('/{id}/update', name: '.update', methods: ['GET', 'POST'])]
    public function update(?ProductImage $productImage, Request $request): Response|RedirectResponse
    {
        if (!$productImage) {
            $this->addFlash('error', 'L\'image demandée n\'existe pas');
            return $this->redirectToRoute('admin.productImage.index');
        }

        $form = $this->createForm(ProductImageType::class, $productImage);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $this->em->persist($productImage);
            $this->em->flush();

            $this->addFlash('success', 'Image mis à jour avec succés');

            return $this->redirectToRoute('admin.productImage.index');
        }

        return $this->render('Backend/ProductImage/update.html.twig', [
            'form' => $form,
        ]);
    }
}
