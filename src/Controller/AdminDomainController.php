<?php

namespace App\Controller;

use App\Entity\Domain;
use App\Form\DomainType;
use App\Repository\DomainRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

#[Route('/admin/domain')]
class AdminDomainController extends AbstractController
{
    #[Route('/', name: 'app_admin_domain_index', methods: ['GET'])]
    public function index(DomainRepository $domainRepository): Response
    {
        return $this->render('admin_domain/index.html.twig', [
            'domains' => $domainRepository->findAll(),
        ]);
    }

    #[Route('/new', name: 'app_admin_domain_new', methods: ['GET', 'POST'])]
    public function new(Request $request, EntityManagerInterface $entityManager): Response
    {
        $domain = new Domain();
        $form = $this->createForm(DomainType::class, $domain);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager->persist($domain);
            $entityManager->flush();

            return $this->redirectToRoute('app_admin_domain_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->render('admin_domain/new.html.twig', [
            'domain' => $domain,
            'form' => $form,
        ]);
    }

    #[Route('/{id}', name: 'app_admin_domain_show', methods: ['GET'])]
    public function show(Domain $domain): Response
    {
        return $this->render('admin_domain/show.html.twig', [
            'domain' => $domain,
        ]);
    }

    #[Route('/{id}/edit', name: 'app_admin_domain_edit', methods: ['GET', 'POST'])]
    public function edit(Request $request, Domain $domain, EntityManagerInterface $entityManager): Response
    {
        $form = $this->createForm(DomainType::class, $domain);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager->flush();

            return $this->redirectToRoute('app_admin_domain_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->render('admin_domain/edit.html.twig', [
            'domain' => $domain,
            'form' => $form,
        ]);
    }

    #[Route('/{id}', name: 'app_admin_domain_delete', methods: ['POST'])]
    public function delete(Request $request, Domain $domain, EntityManagerInterface $entityManager): Response
    {
        if ($this->isCsrfTokenValid('delete'.$domain->getId(), $request->request->get('_token'))) {
            $entityManager->remove($domain);
            $entityManager->flush();
        }

        return $this->redirectToRoute('app_admin_domain_index', [], Response::HTTP_SEE_OTHER);
    }
}
