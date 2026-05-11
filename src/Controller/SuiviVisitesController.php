<?php
// src/Controller/SuiviVisitesController.php
namespace App\Controller;

use App\Entity\Visite;
use App\Form\VisiteType;
use App\Service\TraceabiliteService; // <-- N'oublie pas d'importer le service
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;
use App\Repository\StageRepository;

#[Route('/suivi-visites')]
class SuiviVisitesController extends AbstractController
{
    #[Route('/new', name: 'app_suivi_visites_new', methods: ['GET','POST'])]
    public function new(Request $request, EntityManagerInterface $em, StageRepository $stageRepo, TraceabiliteService $traceur): Response // <-- Injection du service
    {
        $visite = new Visite();

        // --- PRÉ-REMPLISSAGE DU STAGE ---
        $stageId = $request->query->get('stage_id');
        
        if ($stageId) {
            $stage = $stageRepo->find($stageId);
            if ($stage) {
                // On pré-remplit l'entité Visite avec ce stage
                $visite->setStage($stage);
            }
        }
        // --------------------------------

        $form = $this->createForm(VisiteType::class, $visite);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em->persist($visite);
            $em->flush();

            // --- TRAÇABILITÉ AUTOMATIQUE ---
            // On s'assure qu'un stage est bien lié avant de tracer
            if ($visite->getStage()) {
                $dateVisiteStr = $visite->getDateVisite() ? $visite->getDateVisite()->format('d/m/Y') : 'non définie';
                $traceur->logAction($visite->getStage(), "Planification d'une visite le " . $dateVisiteStr);
            }
            // -------------------------------

            // Redirection vers le tableau consolidé
            return $this->redirectToRoute('app_suivi_index');
        }

        return $this->render('suivi_visites/new.html.twig', [
            'form' => $form,
        ]);
    }

    #[Route('/{id}/edit', name: 'app_suivi_visites_edit', methods: ['GET','POST'])]
    public function edit(Request $request, Visite $visite, EntityManagerInterface $em, TraceabiliteService $traceur): Response // <-- Injection du service
    {
        $form = $this->createForm(VisiteType::class, $visite);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em->flush();
            
            // --- TRAÇABILITÉ AUTOMATIQUE ---
            if ($visite->getStage()) {
                $traceur->logAction($visite->getStage(), "Mise à jour des informations de la visite");
            }
            // -------------------------------
            
            // Redirection vers le tableau consolidé
            return $this->redirectToRoute('app_suivi_index');
        }

        return $this->render('suivi_visites/edit.html.twig', [
            'form' => $form,
        ]);
    }

    #[Route('/{id}', name: 'app_suivi_visites_delete', methods: ['POST'])]
    public function delete(Request $request, Visite $visite, EntityManagerInterface $em, TraceabiliteService $traceur): Response // <-- Injection du service
    {
        if ($this->isCsrfTokenValid('delete'.$visite->getId(), $request->request->get('_token'))) {
            // --- TRAÇABILITÉ AUTOMATIQUE ---
            // Il faut tracer AVANT de supprimer l'entité, sinon on perd la référence au stage !
            $stage = $visite->getStage();
            if ($stage) {
                $traceur->logAction($stage, "Annulation/Suppression de la visite");
            }
            // -------------------------------

            $em->remove($visite);
            $em->flush();
        }

        // Redirection vers le tableau consolidé
        return $this->redirectToRoute('app_suivi_index');
    }
}