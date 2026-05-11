<?php

namespace App\Controller;

use App\Repository\EtudiantRepository;
use App\Repository\EntrepriseRepository;
use App\Repository\StageRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\StreamedResponse;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Security\Http\Attribute\IsGranted;

#[IsGranted('ROLE_ADMIN')]
#[Route('/admin/exports')]
class ExportController extends AbstractController
{
    // Affiche la page avec les 3 blocs (comme sur ta maquette)
    #[Route('/', name: 'app_exports_index')]
    public function index(): Response
    {
        return $this->render('export/index.html.twig');
    }

    // --- 1. EXPORT ETUDIANTS ---
    #[Route('/etudiants', name: 'app_export_etudiants')]
    public function exportEtudiants(EtudiantRepository $repo): StreamedResponse
    {
        $etudiants = $repo->findAll();

        $response = new StreamedResponse(function () use ($etudiants) {
            $handle = fopen('php://output', 'w+');
            fputs($handle, "\xEF\xBB\xBF"); // BOM UTF-8

            // En-têtes CSV
            fputcsv($handle, ['ID', 'Nom', 'Prénom', 'Filière', 'Promotion', 'Email', 'Téléphone'], ';');

            foreach ($etudiants as $etu) {
                fputcsv($handle, [
                    $etu->getId(),
                    $etu->getNom(),
                    $etu->getPrenom(),
                    $etu->getFiliere(),
                    $etu->getPromotion(),
                    $etu->getEmail(),
                    $etu->getTelephone()
                ], ';');
            }
            fclose($handle);
        });

        $response->headers->set('Content-Type', 'text/csv; charset=utf-8');
        $response->headers->set('Content-Disposition', 'attachment; filename="etudiants_' . date('Ymd') . '.csv"');

        return $response;
    }

    // --- 2. EXPORT ENTREPRISES ---
    #[Route('/entreprises', name: 'app_export_entreprises')]
    public function exportEntreprises(EntrepriseRepository $repo): StreamedResponse
    {
        $entreprises = $repo->findAll();

        $response = new StreamedResponse(function () use ($entreprises) {
            $handle = fopen('php://output', 'w+');
            fputs($handle, "\xEF\xBB\xBF"); // BOM UTF-8

            fputcsv($handle, ['ID', 'Nom', 'Adresse', 'Code Postal', 'Ville', 'Email', 'Téléphone', 'Tuteur'], ';');

            foreach ($entreprises as $ent) {
                fputcsv($handle, [
                    $ent->getId(),
                    $ent->getNom(),
                    $ent->getAdresse(),
                    $ent->getCodePostal(),
                    $ent->getVille(),
                    $ent->getEmail(),
                    $ent->getTelephone(),
                    $ent->getTuteurNom()
                ], ';');
            }
            fclose($handle);
        });

        $response->headers->set('Content-Type', 'text/csv; charset=utf-8');
        $response->headers->set('Content-Disposition', 'attachment; filename="entreprises_' . date('Ymd') . '.csv"');

        return $response;
    }

    // --- 3. EXPORT STAGES ---
    #[Route('/stages', name: 'app_export_stages')]
    public function exportStages(StageRepository $repo): StreamedResponse
    {
        $stages = $repo->findAll();

        $response = new StreamedResponse(function () use ($stages) {
            $handle = fopen('php://output', 'w+');
            fputs($handle, "\xEF\xBB\xBF"); // BOM UTF-8

            fputcsv($handle, [
                'ID Stage', 'Étudiant', 'Filière', 'Entreprise', 
                'Date début', 'Date fin', 'Prof Suivi', 'Prof Visite', 'Attestation'
            ], ';');

            foreach ($stages as $stage) {
                $etu = $stage->getEtudiant();
                $ent = $stage->getEntreprise();
                $ps = $stage->getProfSuivi();
                $pv = $stage->getProfVisite();

                fputcsv($handle, [
                    $stage->getId(),
                    $etu ? $etu->getNom() . ' ' . $etu->getPrenom() : 'N/A',
                    $etu ? $etu->getFiliere() : 'N/A',
                    $ent ? $ent->getNom() : 'N/A',
                    $stage->getDateDebut() ? $stage->getDateDebut()->format('d/m/Y') : '',
                    $stage->getDateFin() ? $stage->getDateFin()->format('d/m/Y') : '',
                    $ps ? $ps->getNom() : 'Non assigné',
                    $pv ? $pv->getNom() : 'Non assigné',
                    $stage->getStatutAttestation() ?? 'Non saisi'
                ], ';');
            }
            fclose($handle);
        });

        $response->headers->set('Content-Type', 'text/csv; charset=utf-8');
        $response->headers->set('Content-Disposition', 'attachment; filename="stages_' . date('Ymd') . '.csv"');

        return $response;
    }
}