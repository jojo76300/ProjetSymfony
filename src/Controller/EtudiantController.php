<?php

namespace App\Controller;

use App\Entity\Etudiant;
use App\Form\EtudiantType;
use App\Repository\EtudiantRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

#[Route('/etudiant')]
class EtudiantController extends AbstractController
{
    #[Route('/', name: 'app_etudiant_index', methods: ['GET'])]
    public function index(Request $request, EtudiantRepository $repo): Response
    {
        // sens de tri récupéré dans l’URL, par défaut ASC
        $sort = $request->query->get('sort', 'ASC');

        $etudiants = $repo->findAllOrderedByNom($sort);
        $etudiants = $repo->findAll();

        $total = count($etudiants);
        $nbSlam = 0;
        $nbSisr = 0;

        foreach ($etudiants as $e) {
            if (strtoupper($e->getFiliere()) === 'SLAM') {
                $nbSlam++;
            } elseif (strtoupper($e->getFiliere()) === 'SISR') {
                $nbSisr++;
            }
        }


        return $this->render('etudiant/index.html.twig', [
            'etudiants' => $etudiants,
            'sort' => $sort,
            'totaletudiant'=> $total,
            'NbrSlAM'=>$nbSlam,
            'NbrSISR'=>$nbSisr,
        ]);
    }

    #[Route('/new', name: 'app_etudiant_new', methods: ['GET', 'POST'])]
    public function new(Request $request, EntityManagerInterface $em): Response
    {
        $etudiant = new Etudiant();
        $form = $this->createForm(EtudiantType::class, $etudiant);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $etudiant->setIsArchived(false);
            $em->persist($etudiant);
            $em->flush();

            return $this->redirectToRoute('app_etudiant_index');
        }

        return $this->render('etudiant/new.html.twig', [
            'form' => $form,
        ]);
    }

    #[Route('/{id}', name: 'app_etudiant_show', methods: ['GET'])]
    public function show(Etudiant $etudiant): Response
    {
        return $this->render('etudiant/show.html.twig', [
            'etudiant' => $etudiant,
        ]);
    }

    #[Route('/{id}/edit', name: 'app_etudiant_edit', methods: ['GET', 'POST'])]
    public function edit(Request $request, Etudiant $etudiant, EntityManagerInterface $em): Response
    {
        $form = $this->createForm(EtudiantType::class, $etudiant);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em->flush();

            return $this->redirectToRoute('app_etudiant_index');
        }

        return $this->render('etudiant/edit.html.twig', [
            'form' => $form,
        ]);
    }

    #[Route('/{id}', name: 'app_etudiant_delete', methods: ['POST'])]
    public function delete(Request $request, Etudiant $etudiant, EntityManagerInterface $em): Response
    {
        if ($this->isCsrfTokenValid('delete'.$etudiant->getId(), $request->request->get('_token'))) {
            // Soft delete : on archive au lieu de supprimer
            $etudiant->setIsArchived(true);
            $em->flush();
        }

        return $this->redirectToRoute('app_etudiant_index');
    }
}
