<?php

namespace App\Controller;

use App\Entity\Wish;
use App\Repository\WishRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

#[Route('/wish', name: 'wish')] // Prefixe
class WishController extends AbstractController
{
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
}
