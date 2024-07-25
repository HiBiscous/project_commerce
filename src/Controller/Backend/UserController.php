<?php

namespace App\Controller\Backend;

use App\Entity\User;
use App\Form\UserType;
use App\Repository\UserRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;

#[Route('/admin/users', name: 'admin.users')]
class UserController extends AbstractController
{
    public function __construct(private EntityManagerInterface $em,)
    {
    }
    #[Route('/', name: '.index', methods: ['GET'])]
    public function index(UserRepository $repo): Response
    {
        return $this->render('Backend/User/index.html.twig', [
            'users' => $repo->findAll(),
        ]);
    }

    #[Route('/{id}/update', name: '.update', methods: ['GET', 'POST'])]
    public function update(?User $user, Request $request): Response|RedirectResponse
    {
        if (!$user) {
            $this->addFlash('error', 'Utilisateur introuvable');

            return $this->redirectToRoute('admin.users.index');
        }
        $form = $this->createForm(UserType::class, $user, ['isAdmin' => true]);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $this->em->persist($user);
            $this->em->flush();

            $this->addFlash('success', 'Utilisateur mis à jour avec succés');

            return $this->redirectToRoute('admin.users.index');
        }

        return $this->render('Backend/User/update.html.twig', [
            'form' => $form,
        ]);
    }

    #[Route('/{id}/delete', name: '.delete', methods: ['POST'])]
    public function delete(?User $user, Request $request): Response|RedirectResponse
    {
        if (!$user) {
            $this->addFlash('error', 'Utilisateur introuvable');

            return $this->redirectToRoute('admin.users.index');
        }

        if ($this->isCsrfTokenValid('delete' . $user->getId(), $request->request->get('token'))) {
            $this->em->remove($user);
            $this->em->flush();

            $this->addFlash('success', 'L\'Utilisateur a bien été supprimé');
        } else {
            $this->addFlash('error', 'Le jeton CSRF est invalide');
        }

        return $this->redirectToRoute('admin.users.index');
    }
}
