<?php

namespace App\Form;

use App\Entity\Category;
use App\Entity\Recipe;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\CheckboxType;
use Symfony\Component\Form\Extension\Core\Type\FileType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class AdminRecipeCreateFormType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('title', TextType::class, options: ['label' => 'Titre de la recette',
                'attr' => ['class' => 'form-control'],
                'label_attr' => ['class' => 'form-label']]
            )
            ->add('ingredients', TextType::class, options: [
                'label'=> 'Ingrédients',
                'attr' => ['class' =>'form-control'],
                'label_attr' => ['class' => 'form-label']
            ])
            ->add('instructions', TextareaType::class, options: [
                'label'=> 'Instructions',
                'attr' => ['class' =>'form-control'],
                'label_attr' => ['class' => 'form-label']
            ])
            //je spécifie que pour l'ajout d'image j'ai un fileType
            ->add('image', FileType::class, options: [
                //je lui dit de ne pas prendre en compte dans le handle(request)
                'mapped' => false,
                'label' => 'Image d\'illustration',
                'attr' => ['class' => 'form-control'],
                'label_attr' => ['class' => 'form-label']
            ])
            //je met en choix de label title au lieu de l'id des catgeories
            ->add('category', EntityType::class, [
                'class' => Category::class,
                'choice_label' => 'title',
                'label' => 'Catégorie correspondante',
                'attr' => ['class' => 'form-control'],
                'label_attr' => ['class' => 'form-label']
            ])
            ->add('isPublished', CheckboxType::class, [
                'label' => 'Publié ?',
                'attr' => ['class' => 'form-check-input mt-3'],
                'label_attr' => ['class' => 'form-check- mt-3']
            ])
            //j'aoute un bouton pour soumettre, c'est plus pratique en général
            ->add('enregistrer', SubmitType::class, options: [
                'attr' => ['class' => 'btn btn-success mt-3'],
            ]);
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Recipe::class,
        ]);
    }
}
