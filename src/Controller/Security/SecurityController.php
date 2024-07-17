<?php

namespace App\Controller\Security;

use App\Entity\User;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Security\Http\Authentication\AuthenticationUtils;

class SecurityController extends AbstractController
{
    #[Route('/login', name: 'app.login', methods: ['GET', 'POST'])]
    public function index(AuthenticationUtils $authUtils): Response
    {
        $errors = $authUtils->getLastAuthenticationError();
        $lastUserName = $authUtils->getLastUsername();
        return $this->render('Security/login.html.twig', [
            'errors' => $errors,
            'lastUserName' => $lastUserName,
        ]);
    }

    public function register(): Response|RedirectResponse
    {
        $user = new User;
    }
}
