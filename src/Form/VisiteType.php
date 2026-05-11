<?php
// src/Form/VisiteType.php
namespace App\Form;

use App\Entity\Visite;
use App\Entity\Stage;
use App\Entity\Utilisateur;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\DateType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class VisiteType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('stage', EntityType::class, [
                'class' => Stage::class,
                'choice_label' => function (Stage $s) {
                    return $s->getEtudiant()->getNom().' '.$s->getEtudiant()->getPrenom()
                        .' - '.$s->getEntreprise()->getNom();
                },
                'label' => 'Stage',
            ])
            ->add('dateVisite', DateType::class, [
                'widget' => 'single_text',
                'label' => 'Date de visite',
            ])
            ->add('enseignantVisiteur', EntityType::class, [
                'class' => Utilisateur::class,
                'choice_label' => function (Utilisateur $u) {
                    return $u->getNom().' '.$u->getPrenom();
                },
                'placeholder' => 'Choisir un enseignant',
            ])
            ->add('commentaires', TextareaType::class, [
                'required' => false,
                'label' => 'Commentaires (optionnel)',
                'attr' => ['placeholder' => 'Informations complémentaires...'],
            ]);
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Visite::class,
        ]);
    }
}
