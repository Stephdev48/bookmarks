<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

class BookmarkController extends AbstractController
{
    #[Route('/bookmark', name: 'app_bookmark')]
    public function index(): Response
    {
        return $this->render('bookmark/index.html.twig', [
            'controller_name' => 'BookmarkController',
        ]);
    }
}
