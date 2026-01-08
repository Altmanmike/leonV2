<?php

namespace App\Form;

use App\Entity\Film;
use App\Entity\Genre;
use App\Entity\Realisateur;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\FileType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\NumberType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;

class FilmFormType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('titre', TextType::class, [
                'attr' => [
                    'class' => 'form-control',
                    'placeholder' => 'Titre du film'
                ],
                'label' => 'Titre',
                'label_attr' => ['class' => 'my-2']
            ])
            ->add('annee', NumberType::class, [
                'attr' => [
                    'class' => 'form-control',
                    'placeholder' => 'Annéee de sortie'
                ],
                'label' => 'Année',
                'label_attr' => ['class' => 'my-2']
            ])
            ->add('image', FileType::class, [
                'attr' => [
                    'class' => 'form-control',
                    'placeholder' => 'Couverture du film'
                ],
                'label' => 'Couverture',
                'label_attr' => ['class' => 'my-2']
            ])
            ->add('synopsis', TextareaType::class, [
                'attr' => [
                    'class' => 'form-control',
                    'placeholder' => 'Synopsis du film'
                ],
                'label' => 'Synopsis',
                'label_attr' => ['class' => 'my-2']
            ])
            ->add('createdAt', null, [
                'attr' => [
                    'class' => 'form-control',
                    'placeholder' => 'Date d\'ajout'
                ],
                'label' => 'Ajouté le',
                'widget' => 'single_text',
                'label_attr' => ['class' => 'my-2']
            ])
            ->add('updatedAt', null, [
                'attr' => [
                    'class' => 'form-control',
                    'placeholder' => 'Date de modification'
                ],
                'label' => 'Mis à jour le',
                'widget' => 'single_text',
                'label_attr' => ['class' => 'my-2']
            ])
            ->add('realisateur', EntityType::class, [                
                'attr' => [
                    'class' => 'form-control'                    
                ],
                'class' => Realisateur::class,
                'choice_label' => 'id',
                'label_attr' => ['class' => 'my-2']
            ])
            ->add('genres', EntityType::class, [                
                'attr' => [
                    'class' => 'form-control d-flex flex-wrap gap-2 mb-4'                    
                ],
                'class' => Genre::class,
                'choice_label' => 'id',                
                'multiple' => true,
                'expanded' => true,
                'label_attr' => ['class' => 'my-2']
            ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Film::class,
        ]);
    }
}