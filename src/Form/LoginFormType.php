<?php

// src/Form/LoginFormType.php

namespace App\Form;

use App\Entity\User;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\PasswordType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class LoginFormType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('username', TextType::class, [
                'label' => 'Username or Email',
                'attr' => ['placeholder' => 'Enter your username or email']
            ])
            ->add('password', PasswordType::class, [
                'label' => 'Password',
                'attr' => ['placeholder' => 'Enter your password']
            ])
            ->add('submit', SubmitType::class, [
                'label' => 'Login',
                'attr' => ['class' => 'btn btn-primary']
            ]);
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => User::class, // Specify the User entity class
        ]);
    }
}
