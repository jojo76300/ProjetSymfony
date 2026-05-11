<?php
namespace App\Controller;

use App\Entity\Stage;
use App\Form\StageType;
use App\Repository\StageRepository;
use App\Service\TraceabiliteService; // <-- N'oublie pas le use du service !
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;
use Symfony\Component\Security\Http\Attribute\IsGranted;

#[Route('/stage')]
class StageController extends AbstractController
{
    #[Route('/', name: 'app_stage_index', methods: ['GET'])]
    public function index(StageRepository $repo): Response
    {
        return $this->render('stage/index.html.twig', [
            'stages' => $repo->findAll(), 
        ]);
    }

    #[Route('/new', name: 'app_stage_new', methods: ['GET','POST'])]
    public function new(Request $request, EntityManagerInterface $em, TraceabiliteService $traceur): Response // Injection du service
    {
        $stage = new Stage();
        $form = $this->createForm(StageType::class, $stage);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            if ($stage->getDateFin() < $stage->getDateDebut()) {
                $this->addFlash('error', 'La date de fin doit être supérieure à la date de début.');
            } else {
                $em->persist($stage);
                $em->flush();

                // --- TRAÇABILITÉ AUTOMATIQUE ---
                $traceur->logAction($stage, "Création du dossier de stage");

                return $this->redirectToRoute('app_stage_index');
            }
        }

        return $this->render('stage/new.html.twig', [
            'form' => $form,
        ]);
    }

    #[Route('/{id}/edit', name: 'app_stage_edit', methods: ['GET','POST'])]
    #[IsGranted('STAGE_EDIT', subject: 'stage')]
    public function edit(Request $request, Stage $stage, EntityManagerInterface $em, TraceabiliteService $traceur): Response // Injection du service
    {
        // On sauvegarde l'ancien statut avant modification pour comparer
        $ancienStatut = $stage->getStatutAttestation();

        $form = $this->createForm(StageType::class, $stage);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            if ($stage->getDateFin() < $stage->getDateDebut()) {
                $this->addFlash('error', 'La date de fin doit être supérieure à la date de début.');
            } else {
                $em->flush();

                // --- TRAÇABILITÉ AUTOMATIQUE ---
                $nouveauStatut = $stage->getStatutAttestation();
                if ($ancienStatut !== $nouveauStatut) {
                    $traceur->logAction($stage, "Changement de statut de l'attestation : passé à '" . $nouveauStatut . "'");
                } else {
                    $traceur->logAction($stage, "Modification des informations générales du stage");
                }

                // Redirection intelligente (retour vers Suivi si on vient de là, sinon Stages)
                $referer = $request->headers->get('referer');
                if ($referer && str_contains($referer, '/suivi')) {
                    return $this->redirect($referer);
                }
                
                return $this->redirectToRoute('app_stage_index');
            }
        }

        return $this->render('stage/edit.html.twig', [
            'form' => $form,
        ]);
    }

    #[Route('/{id}', name: 'app_stage_delete', methods: ['POST'])]
    #[IsGranted('STAGE_DELETE', subject: 'stage')]
    public function delete(Request $request, Stage $stage, EntityManagerInterface $em): Response
    {
        if ($this->isCsrfTokenValid('delete'.$stage->getId(), $request->request->get('_token'))) {
            // Note: Si tu as une contrainte de clé étrangère avec Historique, 
            // tu devras peut-être configurer 'onDelete="CASCADE"' dans ton entité Historique
            $em->remove($stage);
            $em->flush();
        }

        return $this->redirectToRoute('app_stage_index');
    }

    #[Route('/{id}/historique', name: 'app_stage_historique', methods: ['GET'])]
    public function historique(Stage $stage): Response
    {
        // Cette vue affichera la liste des événements liés à ce stage précis
        return $this->render('stage/historique.html.twig', [
            'stage' => $stage,
        ]);
    }

}