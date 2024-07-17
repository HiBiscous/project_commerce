<?php

namespace App\Controller\Security;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

class SecurityController extends AbstractController
{
    #[Route('/security/security', name: 'app_security_security')]
    public function index(): Response
    {
        return $this->render('security/security/index.html.twig', [
            'controller_name' => 'SecurityController',
        ]);
    }
}
