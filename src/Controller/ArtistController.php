<?php

// src/Controller/ArtistController.php

namespace App\Controller;

use App\Entity\Artist;
use App\Form\ArtistType;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class ArtistController extends AbstractController
{
    private $entityManager;

    public function __construct(EntityManagerInterface $entityManager)
    {
        $this->entityManager = $entityManager;
    }

    /**
     * @Route("/artists", name="artist_index", methods={"GET"})
     */
    public function index(): Response
    {
        $artists = $this->entityManager->getRepository(Artist::class)->findAll();

        return $this->render('artist/index.html.twig', [
            'artists' => $artists,
        ]);
    }

    /**
     * @Route("/artists/new", name="artist_new", methods={"GET", "POST"})
     */
    public function new(Request $request): Response
    {
        $artist = new Artist();
        $form = $this->createForm(ArtistType::class, $artist);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $this->entityManager->persist($artist);
            $this->entityManager->flush();

            return $this->redirectToRoute('artist_index');
        }

        return $this->render('artist/new.html.twig', [
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/artists/{id}", name="artist_show", methods={"GET"})
     */
    public function show(Artist $artist): Response
    {
        return $this->render('artist/show.html.twig', [
            'artist' => $artist,
        ]);
    }

    /**
     * @Route("/artists/{id}/edit", name="artist_edit", methods={"GET", "POST"})
     */
    public function edit(Request $request, Artist $artist): Response
    {
        $form = $this->createForm(ArtistType::class, $artist);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $this->entityManager->flush();

            return $this->redirectToRoute('artist_index');
        }

        return $this->render('artist/edit.html.twig', [
            'artist' => $artist,
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/artists/{id}/delete", name="artist_delete", methods={"POST"})
     */
    public function delete(Request $request, Artist $artist): Response
    {
        if ($this->isCsrfTokenValid('delete' . $artist->getId(), $request->request->get('_token'))) {
            $this->entityManager->remove($artist);
            $this->entityManager->flush();
        }

        return $this->redirectToRoute('artist_index');
    }
}
