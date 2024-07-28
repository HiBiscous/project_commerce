<?php

namespace App\Controller\Backend;

use App\Entity\Gender;
use App\Form\GenderType;
use App\Repository\GenderRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

#[Route('/admin/gender', name: 'admin.gender')]
class GenderController extends AbstractController
{
    public function __construct(private EntityManagerInterface $em)
    {
    }
    #[Route('/', name: '.index', methods: ['GET'])]
    public function index(GenderRepository $repo): Response
    {
        return $this->render('Backend/Gender/index.html.twig', [
            'genders' => $repo->findAll()
        ]);
    }

    #[Route('/create', name: '.create', methods: ['GET', 'POST'])]
    public function create(Request $request): Response|RedirectResponse
    {
        $gender = new Gender;
        $form = $this->createForm(GenderType::class, $gender);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $this->em->persist($gender);
            $this->em->flush();

            $this->addFlash('success', 'Le genre a bien été crée.');

            return $this->redirectToRoute('admin.gender.index');
        }

        return $this->render('Backend/Gender/create.html.twig', [
            'form' => $form,
        ]);
    }

    #[Route('/{id}/update', name: '.update', methods: ['GET', 'POST'])]
    public function update(?Gender $gender, Request $request): Response|RedirectResponse
    {
        if (!$gender) {
            $this->addFlash('error', 'Le genre demandé n\'existe pas');

            return $this->redirectToRoute('admin.gender.index');
        }

        $form = $this->createForm(GenderType::class, $gender);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $this->em->persist($gender);
            $this->em->flush();

            $this->addFlash('success', 'Le genre a bien été mis à jour');
            return $this->redirectToRoute('admin.gender.index');
        }

        return $this->render('Backend/Gender/update.html.twig', [
            'form' => $form,
        ]);
    }

    #[Route('/{id}/delete', name: '.delete', methods: ['POST'])]
    public function delete(?Gender $gender, Request $request): Response|RedirectResponse
    {
        if (!$gender) {

            $this->addflash('error', 'Le genre demandé n\'existe pas.');
            return $this->redirectToRoute('admin.gender.index');
        }

        if ($this->isCsrfTokenValid('delete' . $gender->getId(), $request->request->get('token'))) {
            $this->em->remove($gender);
            $this->em->flush();

            $this->addFlash('success', 'Le Genre a bien été supprimé');
            return $this->redirectToRoute('admin.gender.index');
        } else {
            $this->addFlash('error', 'Le jeton csrf est invalide');
        }

        return $this->redirectToRoute('admin.gender.index');
    }
}
