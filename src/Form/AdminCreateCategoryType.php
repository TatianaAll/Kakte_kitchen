<?php

namespace App\Form;

use App\Entity\Category;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class AdminCreateCategoryType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('title', TextType::class, options: ['label' => 'Titre de la catégorie',
                'attr' => ['class' => 'form-control'],
                'label_attr' => ['class' => 'form-label']])
            //j'aoute un bouton pour soumettre, c'est plus pratique en général
            ->add('Enregistrer', SubmitType::class, options: [
                'attr' => ['class' => 'btn btn-success mt-3'],
            ]);
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Category::class,
        ]);
    }
}
