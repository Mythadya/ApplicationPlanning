<?php

namespace App\Form;

use App\Entity\Formation;
use App\Entity\Formateur;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\CheckboxType;
use Symfony\Component\Form\Extension\Core\Type\DateType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class FormationType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('nom', TextType::class)
            ->add('numero', TextType::class, [
                'required' => false,
            ])
            ->add('etat', ChoiceType::class, [
                'choices' => [
                    'Validée' => 'VALIDEE',
                    'En cours de validation' => 'EN_COURS_DE_VALIDATION',
                ],
            ])
            ->add('titrePro', TextType::class, [
                'required' => false,
            ])
            ->add('niveau', TextType::class, [
                'required' => false,
            ])
            ->add('nbStagiairesPrevision', TextType::class, [
                'required' => false,
            ])
            ->add('groupeRattachement', TextType::class, [
                'required' => false,
            ])
            ->add('dateDebut', DateType::class, [
                'widget' => 'single_text',
            ])
            ->add('dateFin', DateType::class, [
                'widget' => 'single_text',
            ])
            ->add('actif', CheckboxType::class, [
                'required' => false,
            ])
            ->add('formateur', EntityType::class, [
                'class' => Formateur::class,
                'choice_label' => function (Formateur $formateur) {
                    return $formateur->getPrenom() . ' ' . $formateur->getNom();
                },
                'placeholder' => 'Choisir un formateur',
            ]);
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Formation::class,
        ]);
    }
}
