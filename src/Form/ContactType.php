<?php

namespace App\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\EmailType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\Validator\Constraints as Assert;

class ContactType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('name', TextType::class, [
                'constraints' => [
                    new Assert\NotNull(),
                    new Assert\Length(min: 5),
                ]
            ])
            ->add('email', EmailType::class, [
                'constraints' => [
                    new Assert\NotNull(),
                    new Assert\Email(),
                ]
            ])
            ->add('subject', TextType::class, [
                'constraints' => [
                    new Assert\NotNull(),
                    new Assert\Length(min: 10)
                ]
            ])
            ->add('message', TextareaType::class, [
                'constraints' => [
                    new Assert\NotNull(),
                    new Assert\Length(min: 20),
                ]
            ])
        ;
    }
}
