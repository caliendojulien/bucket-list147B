<?php

namespace App\Controller;

use App\Entity\Wish;
use App\Form\WishType;
use App\Repository\WishRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

#[Route('/wish', name: 'wish')] // Prefixe
class WishController extends AbstractController
{
    #[Route('/supprimer/{wish}', name: '_supprimer')]
    public function supprimer(
        Wish                   $wish,
        EntityManagerInterface $entityManager
    ): Response
    {
        $entityManager->remove($wish);
        $entityManager->flush();
        return $this->redirectToRoute('wish_list');
    }

    #[Route('/modifier/{wish}', name: '_modifier')]
    public function modifier(
        Wish                   $wish,
        EntityManagerInterface $entityManager,
        Request                $request
    ): Response
    {
        $wishForm = $this->createForm(WishType::class, $wish);
        $wishForm->handleRequest($request);
        if($wishForm->isSubmitted() && $wishForm->isValid()) {
            $entityManager->persist($wish); // UPDATE
            $entityManager->flush();
            return $this->redirectToRoute('wish_list');
        }
        return $this->render(
            'wish/modifier.html.twig',
            compact('wishForm')
        );
    }

    #[Route('/', name: '_list')]
    public function list(
        WishRepository $wishRepository
    ): Response
    {
        $wishes = $wishRepository->findBy(
            ["isPublished" => true]
        );
        return $this->render('wish/list.html.twig',
            compact('wishes')
        );
    }

    #[Route('/detail/{wish}', name: '_detail')]
    public function detail(
        Wish $wish
    ): Response
    {
        if (!$wish) {
            throw $this->createNotFoundException('Ce wish n\'existe pas.');
        }
        return $this->render('wish/detail.html.twig',
            compact('wish')
        );
    }

    #[Route('/nouveau', name: '_nouveau')]
    public function nouveau(
        Request                $request,
        EntityManagerInterface $entityManager
    ): Response
    {
        $wish = new Wish();
        $wishForm = $this->createForm(WishType::class, $wish);
        $wishForm->handleRequest($request);
        if ($wishForm->isSubmitted() && $wishForm->isValid()) {
            try {
                $wish->setDateCreated(new \DateTime());
                $wish->setIsPublished(true);
                $entityManager->persist($wish);
                $entityManager->flush();
                $this->addFlash('succes', 'Le souhait a bien été inséré');
                return $this->redirectToRoute('wish_detail', ["id" => $wish->getId()]);
            } catch (\Exception $exception) {
                $this->addFlash('echec', 'Le souhait n\'a pas été inséré');
                return $this->redirectToRoute('wish_nouveau');
            }
        }
        return $this->render('wish/nouveau.html.twig',
            compact('wishForm')
        );
    }
}
