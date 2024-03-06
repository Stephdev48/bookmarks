<?php

namespace App\Controller;

use App\Entity\Bookmark;
use App\Form\BookmarkType;
use App\Repository\BookmarkRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

#[Route('/admin/bookmark')]
class AdminBookmarkController extends AbstractController
{
    #[Route('/', name: 'app_admin_bookmark_index', methods: ['GET'])]
    public function index(BookmarkRepository $bookmarkRepository): Response
    {
        return $this->render('admin_bookmark/index.html.twig', [
            'bookmarks' => $bookmarkRepository->findAll(),
        ]);
    }

    #[Route('/new', name: 'app_admin_bookmark_new', methods: ['GET', 'POST'])]
    public function new(Request $request, EntityManagerInterface $entityManager): Response
    {
        $bookmark = new Bookmark();
        $form = $this->createForm(BookmarkType::class, $bookmark);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager->persist($bookmark);
            $entityManager->flush();

            return $this->redirectToRoute('app_admin_bookmark_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->render('admin_bookmark/new.html.twig', [
            'bookmark' => $bookmark,
            'form' => $form,
        ]);
    }

    #[Route('/{id}', name: 'app_admin_bookmark_show', methods: ['GET'])]
    public function show(Bookmark $bookmark): Response
    {
        return $this->render('admin_bookmark/show.html.twig', [
            'bookmark' => $bookmark,
        ]);
    }

    #[Route('/{id}/edit', name: 'app_admin_bookmark_edit', methods: ['GET', 'POST'])]
    public function edit(Request $request, Bookmark $bookmark, EntityManagerInterface $entityManager): Response
    {
        $form = $this->createForm(BookmarkType::class, $bookmark);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager->flush();

            return $this->redirectToRoute('app_admin_bookmark_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->render('admin_bookmark/edit.html.twig', [
            'bookmark' => $bookmark,
            'form' => $form,
        ]);
    }

    #[Route('/{id}', name: 'app_admin_bookmark_delete', methods: ['POST'])]
    public function delete(Request $request, Bookmark $bookmark, EntityManagerInterface $entityManager): Response
    {
        if ($this->isCsrfTokenValid('delete'.$bookmark->getId(), $request->request->get('_token'))) {
            $entityManager->remove($bookmark);
            $entityManager->flush();
        }

        return $this->redirectToRoute('app_admin_bookmark_index', [], Response::HTTP_SEE_OTHER);
    }
}
