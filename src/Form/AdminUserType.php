<?php

namespace App\Form;

use App\Entity\User;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\EmailType;
use Symfony\Component\Form\Extension\Core\Type\PasswordType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class AdminUserType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('email', EmailType::class, options: ['label' => 'Email',
                'attr' => ['class' => 'form-control'],
                'label_attr' => ['class' => 'form-label']])

            //ce serait cool d'avoir les rôles dans un select et une liste déroulante
            ->add('roles', ChoiceType::class, options: [ 'mapped'=>false
            ])

            //je ne récupère pas directement le password car il faut le passer à la moulinette avant,
            //donc ==> 'mapped' => false
            ->add('password', PasswordType::class, options: ['mapped'=>false,
                'label' => 'Password',])

            //le bouton de soumission du form
            ->add('enregistrer', SubmitType::class, options: [
                'attr' => ['class' => 'btn btn-success mt-3']]);
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => User::class,
        ]);
    }
}


//            ->add('roles', EntityType::class, options: [
//                'class' => User::class,
//                'choice_label' => 'roles',
//                'label' => 'Roles',
//                'attr' => ['class' => 'form-control'],
//                'label_attr' => ['class' => 'form-label']
//            ])