<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

#[Route('/wish', name: 'wish')] // Prefixe
class WishController extends AbstractController
{
    #[Route('/', name: '_list')]
    public function list(): Response
    {
        return $this->render('wish/list.html.twig');
    }

    #[Route('/detail/{id}', name: '_detail')]
    public function detail(int $id): Response
    {
        return $this->render('wish/detail.html.twig');
    }
}
