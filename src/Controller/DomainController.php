<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

class DomainController extends AbstractController
{
    #[Route('/domain', name: 'app_domain')]
    public function index(): Response
    {
        return $this->render('domain/index.html.twig', [
            'controller_name' => 'DomainController',
        ]);
    }
}
