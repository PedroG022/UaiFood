<?php

namespace App\Controller;

use App\Repository\StoreRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

class HomeController extends AbstractController
{
    #[Route('/', name: 'app_home')]
    public function index(StoreRepository $storeRepository): Response
    {
        $stores = $storeRepository->findAll();

        return $this->render('home/index.html.twig', [
            'stores' => $stores
        ]);
    }
}
