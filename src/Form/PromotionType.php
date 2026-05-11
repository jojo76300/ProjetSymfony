<?php

namespace App\Form;

use App\Entity\Promotion;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\DateType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class PromotionType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('classe', TextType::class, [
                'label' => 'Classe (*)',
                'required' => true,
            ])
            ->add('session', TextType::class, [
                'label' => 'Session (*)',
                'required' => true,
            ])
            ->add('dateDebutStageDefaut', DateType::class, [
                'widget' => 'single_text',
                'label' => 'Date de début de stage (*)',
                'required' => true,
            ])
            ->add('dateFinStageDefaut', DateType::class, [
                'widget' => 'single_text',
                'label' => 'Date de fin de stage (*)',
                'required' => true,
            ]);
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Promotion::class,
        ]);
    }
}