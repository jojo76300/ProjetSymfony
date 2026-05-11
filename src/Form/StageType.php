<?php
// src/Form/StageType.php

namespace App\Form;

use App\Entity\Stage;
use App\Entity\Etudiant;
use App\Entity\Entreprise;
use App\Entity\Utilisateur;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\DateType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class StageType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('etudiant', EntityType::class, [
                'class' => Etudiant::class,
                'choice_label' => function (Etudiant $e) {
                    return $e->getNom() . ' ' . $e->getPrenom();
                },
                'choice_attr' => function (Etudiant $e) {
                    $promotion = $e->getPromotion();

                    return [
                        'data-date-debut' => $promotion && $promotion->getDateDebutStageDefaut()
                            ? $promotion->getDateDebutStageDefaut()->format('Y-m-d')
                            : '',
                        'data-date-fin' => $promotion && $promotion->getDateFinStageDefaut()
                            ? $promotion->getDateFinStageDefaut()->format('Y-m-d')
                            : '',
                    ];
                },
                'label' => 'Étudiant (*)',
                'placeholder' => 'Choisir un étudiant',
                'required' => true,
            ])
            ->add('entreprise', EntityType::class, [
                'class' => Entreprise::class,
                'choice_label' => 'nom',
                'label' => 'Entreprise',
                'placeholder' => 'Choisir une entreprise',
            ])
            ->add('profSuivi', EntityType::class, [
                'class' => Utilisateur::class,
                'choice_label' => function (Utilisateur $u) {
                    $nomComplet = trim(($u->getPrenom() ?? '') . ' ' . ($u->getNom() ?? ''));
                    return $nomComplet !== '' ? $nomComplet : (string) $u->getEmail();
                },
                'label' => 'Professeur de suivi',
                'placeholder' => 'Choisir le professeur de suivi',
                'required' => false,
            ])
            ->add('profVisite', EntityType::class, [
                'class' => Utilisateur::class,
                'choice_label' => function (Utilisateur $u) {
                    $nomComplet = trim(($u->getPrenom() ?? '') . ' ' . ($u->getNom() ?? ''));
                    return $nomComplet !== '' ? $nomComplet : (string) $u->getEmail();
                },
                'label' => 'Professeur visiteur',
                'placeholder' => 'Choisir le professeur de visite',
                'required' => false,
            ])
            ->add('dateDebut', DateType::class, [
                'widget' => 'single_text',
                'label' => 'Date de début (*)',
                'required' => true,
            ])
            ->add('dateFin', DateType::class, [
                'widget' => 'single_text',
                'label' => 'Date de fin (*)',
                'required' => true,
            ])
            ->add('remarques', TextareaType::class, [
                'required' => false,
                'label' => 'Remarques',
            ])
            ->add('statutAttestation', ChoiceType::class, [
                'label' => 'Attestation',
                'choices' => [
                    'Non saisi' => 'Non saisi',
                    'À faire' => 'À faire',
                    'Reçue' => 'Reçue',
                ],
            ]);
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Stage::class,
        ]);
    }
}