<?php

namespace App\Controller\Backend;

use App\Entity\Marque;
use App\Form\MarqueType;
use App\Repository\MarqueRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

#[Route('admin/marque', name: 'admin.marque')]
class MarqueController extends AbstractController
{
    public function __construct(private EntityManagerInterface $em)
    {
    }

    #[Route('/', name: '.index', methods: ['GET', 'POST'])]
    public function index(MarqueRepository $repo): Response
    {
        return $this->render('Backend/Marque/index.html.twig', [
            'marques' => $repo->findAll(),
        ]);
    }

    #[Route('/create', name: '.create', methods: ['GET', 'POST'])]
    public function create(Request $request): Response|RedirectResponse
    {
        $marque = new Marque;
        $form = $this->createForm(MarqueType::class, $marque);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $marque->setCreatedAt(new \DateTimeImmutable());
            $this->em->persist($marque);
            $this->em->flush();

            $this->addFlash('success', 'La marque a bien été mis à jour');

            return $this->redirectToRoute('admin.marque.index');
        }

        return $this->render('Backend/Marque/create.html.twig', [
            'form' => $form
        ]);
    }

    #[Route('/{id}/update', name: '.update', methods: ['GET', 'POST'])]
    public function update(?Marque $marque, Request $request): Response|RedirectResponse
    {
        if (!$marque) {
            $this->addFlash('error', 'La marque demandé n\'existe pas');
            return $this->redirectToRoute('admin.marque.index');
        }
        $form = $this->createForm(MarqueType::class, $marque);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $marque->setUpdatedAt(new \DateTimeImmutable());
            $this->em->persist($marque);
            $this->em->flush();

            $this->addFlash('success', 'La marque a bien été mis à jour');

            return $this->redirectToRoute('admin.marque.index');
        }

        return $this->render('Backend/Marque/create.html.twig', [
            'form' => $form
        ]);
    }

    #[Route('/{id}/delete', name: '.delete', methods: ['POST'])]
    public function delete(?Marque $marque, Request $request): Response|RedirectResponse
    {
        if (!$marque) {
            $this->addFlash('error', 'La marque demandé n\'existe pas');
            return $this->redirectToRoute('admin.marque.index');
        }

        if ($this->isCsrfTokenValid('delete' . $marque->getId(), $request->request->get('token'))) {
            $this->em->remove($marque);
            $this->em->flush();

            $this->addFlash('success', 'La marque a bien été supprimé');
        } else {
            $this->addFlash('error', 'Le jeton csrf est invalide');
        }

        return $this->redirectToRoute('admin.marque.index');
    }
}
