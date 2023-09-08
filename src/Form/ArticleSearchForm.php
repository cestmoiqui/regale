<?php

namespace App\Form;

use App\Data\ArticleSearchData;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;

class ArticleSearchForm extends AbstractType
{

    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('q', TextType::class, [
                'label' => false, // Removes the label
                'attr' => [
                    'placeholder' => 'Rechercher un article',
                    'class' => 'form-control me-2',
                    'aria-label' => 'Recherhcher un article',
                ],
                'required' => false,
            ])
            ->add('categories', EntityType::class, [
                'label' => false, // Removes the label
                'class' => 'App\Entity\ArticleCategory', // The entity that provides the list of options
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
                    'Meilleurs articles' => 'best',
                    'Plus anciens articles' => 'oldest',
                    'Plus récents articles' => 'latest',
                ],
                'expanded' => true, // Utiliser des cases à cocher au lieu d'une liste déroulante
                'multiple' => false, // Permettre la sélection d'une seule option
                'required' => false,
            ]);
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => ArticleSearchData::class,
            'method' => 'GET',
            'csrf_protection' => false,
        ]);
    }

    public function getBlockPrefix(): string
    {
        return '';
    }
}
