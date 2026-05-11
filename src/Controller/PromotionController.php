<?php

namespace App\Controller;

use App\Entity\Promotion;
use App\Form\PromotionType;
use App\Repository\PromotionRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

#[Route('/promotion')]
class PromotionController extends AbstractController
{
    #[Route('/', name: 'app_promotion_index', methods: ['GET'])]
    public function index(PromotionRepository $repo): Response
    {
        return $this->render('promotion/index.html.twig', [
            'promotions' => $repo->findBy([], ['classe' => 'ASC']),
        ]);
    }

    #[Route('/new', name: 'app_promotion_new', methods: ['GET', 'POST'])]
    public function new(Request $request, EntityManagerInterface $em): Response
    {
        $promotion = new Promotion();
        $form = $this->createForm(PromotionType::class, $promotion);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            if ($promotion->getDateDebutStageDefaut() > $promotion->getDateFinStageDefaut()) {
                $this->addFlash('error', 'La date de début doit être antérieure à la date de fin.');
            } else {
                $em->persist($promotion);
                $em->flush();

                return $this->redirectToRoute('app_promotion_index');
            }
        }

        return $this->render('promotion/new.html.twig', [
            'form' => $form,
        ]);
    }

    #[Route('/{id}/edit', name: 'app_promotion_edit', methods: ['GET', 'POST'])]
    public function edit(Request $request, Promotion $promotion, EntityManagerInterface $em): Response
    {
        $form = $this->createForm(PromotionType::class, $promotion);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            if ($promotion->getDateDebutStageDefaut() > $promotion->getDateFinStageDefaut()) {
                $this->addFlash('error', 'La date de début doit être antérieure à la date de fin.');
            } else {
                $em->flush();

                return $this->redirectToRoute('app_promotion_index');
            }
        }

        return $this->render('promotion/edit.html.twig', [
            'form' => $form,
            'promotion' => $promotion,
        ]);
    }

    #[Route('/{id}', name: 'app_promotion_delete', methods: ['POST'])]
    public function delete(Request $request, Promotion $promotion, EntityManagerInterface $em): Response
    {
        if ($this->isCsrfTokenValid('delete'.$promotion->getId(), $request->request->get('_token'))) {
            $em->remove($promotion);
            $em->flush();
        }

        return $this->redirectToRoute('app_promotion_index');
    }
}