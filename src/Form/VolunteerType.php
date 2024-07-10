<?php

namespace App\Form;

use App\Entity\Event;
use App\Entity\Project;
use App\Entity\User;
use App\Entity\Volunteer;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\DateType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class VolunteerType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('startAt', DateType::class, [
                'widget' => 'single_text',
            ])
            ->add('endAt', DateType::class, [
                'widget' => 'single_text',
            ])
            ->add('forUser', EntityType::class, [
                'class' => User::class,
                'choice_label' => 'username',
            ])
        ;

        if ($options['event'] instanceof Event) {
            $builder
                ->add('event', EntityType::class, [
                    'class' => Event::class,
                    'choice_label' => 'name',
                ]);
        }
        if ($options['project'] instanceof Project) {
            $builder
                ->add('project', EntityType::class, [
                    'class' => Project::class,
                    'choice_label' => 'name',
                ]);
        }
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver
            ->setDefaults([
                'data_class' => Volunteer::class,
                'event' => null,
                'project' => null,
            ])
            ->setAllowedTypes('event', [Event::class, 'null'])
            ->setAllowedTypes('project', [Project::class, 'null'])
        ;
    }
}
