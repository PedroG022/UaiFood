<?php

namespace App\Controller;

use App\Entity\Store;
use App\Form\StoreType;
use App\Repository\StoreRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

#[Route('/store')]
final class StoreController extends AbstractController
{
    #[Route(name: 'app_store_index', methods: ['GET'])]
    public function index(StoreRepository $storeRepository): Response
    {
        $stores = $storeRepository->findBy(['manager' => $this->getUser()]);

        return $this->render('store/index.html.twig', [
            'stores' => $stores,
        ]);
    }

    #[Route('/new', name: 'app_store_new', methods: ['GET', 'POST'])]
    public function new(Request $request, EntityManagerInterface $entityManager): Response
    {
        $store = new Store();
        $form = $this->createForm(StoreType::class, $store);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $store->setManager($this->getUser());
            $entityManager->persist($store);
            $entityManager->flush();

            return $this->redirectToRoute('app_store_show', ['id' => $store->getId()], Response::HTTP_SEE_OTHER);
        }

        return $this->render('store/new.html.twig', [
            'store' => $store,
            'form' => $form,
        ]);
    }

    #[Route('/{id}', name: 'app_store_show', methods: ['GET'])]
    public function show(Store $store): Response
    {
        $isManager = $store->getManager() === $this->getUser();

        return $this->render('store/show.html.twig', [
            'store' => $store,
            'isManager' => $isManager,
        ]);
    }

    #[Route('/{id}/edit', name: 'app_store_edit', methods: ['GET', 'POST'])]
    public function edit(Request $request, Store $store, EntityManagerInterface $entityManager): Response
    {
        if ($store->getManager() !== $this->getUser()) {
            return $this->redirectToRoute('app_access_denied');
        }

        $form = $this->createForm(StoreType::class, $store);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager->flush();

            return $this->redirectToRoute('app_store_show', ['id' => $store->getId()], Response::HTTP_SEE_OTHER);
        }

        return $this->render('store/edit.html.twig', [
            'store' => $store,
            'form' => $form,
        ]);
    }

    #[Route('/{id}', name: 'app_store_delete', methods: ['POST'])]
    public function delete(Request $request, Store $store, EntityManagerInterface $entityManager): Response
    {
        if ($store->getManager() !== $this->getUser()) {
            return $this->redirectToRoute('app_access_denied');
        }

        if ($this->isCsrfTokenValid('delete'.$store->getId(), $request->getPayload()->getString('_token'))) {
            $entityManager->remove($store);
            $entityManager->flush();
        }

        return $this->redirectToRoute('app_store_index', [], Response::HTTP_SEE_OTHER);
    }
}
