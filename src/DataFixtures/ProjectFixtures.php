<?php

namespace App\DataFixtures;

use App\Entity\Event;
use App\Entity\Project;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\DataFixtures\DependentFixtureInterface;
use Doctrine\Persistence\ObjectManager;

class ProjectFixtures extends Fixture implements DependentFixtureInterface
{
    public const SymfonyLive = 'Project_SymfonyLive';

    public function load(ObjectManager $manager): void
    {
        $project = (new Project())
            ->setName('SymfonyLive')
            ->setSummary('Ongoing effort for the SymfonyLive events organization every year.')
            ->setCreatedAt(new \DateTimeImmutable('01-01-2000'));

        for ($i = 2015; $i <= 2025; $i++) {
            $project->addEvent($this->getReference("Event_{$i}", Event::class));
        }

        $this->addReference(self::SymfonyLive, $project);

        $manager->persist($project);
        $manager->flush();
    }

    public function getDependencies(): array
    {
        return [
            EventFixtures::class,
        ];
    }
}
