<?php

namespace App\Form;

use App\Data\RecipeSearchData;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;

class RecipeSearchForm extends AbstractType
{

    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('q', TextType::class, [
                'label' => false, // Removes the label
                'attr' => [
                    'placeholder' => 'Rechercher une recette',
                    'class' => 'form-control me-2',
                    'aria-label' => 'Rechercher une recette',
                ],
                'required' => false,
            ])
            ->add('categories', EntityType::class, [
                'label' => false, // Removes the label
                'class' => 'App\Entity\RecipeCategory', // The entity that provides the list of options
                'expanded' => true, // Displays the checkboxes in a list
                'multiple' => true, // Allows multiple selections
                'attr' => [
                    'class' => 'form-check-input',
                ],
                'required' => false,
            ])
            ->add('tags', EntityType::class, [
                'class' => 'App\Entity\Tag',
                'choice_label' => 'name',
                'multiple' => true,
                'expanded' => true,
            ])
            ->add('sort', ChoiceType::class, [
                'label' => 'Sélectionner le tri',
                'choices' => [
                    'Meilleurs recipes' => 'best',
                    'Plus anciens recipes' => 'oldest',
                    'Plus récents recipes' => 'latest',
                ],
                'expanded' => true, // Utiliser des cases à cocher au lieu d'une liste déroulante
                'multiple' => false, // Permettre la sélection d'une seule option
                'required' => false,
            ]);
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => RecipeSearchData::class,
            'method' => 'GET',
            'csrf_protection' => false,
        ]);
    }

    public function getBlockPrefix(): string
    {
        return '';
    }
}
