<?php

namespace App\DataFixtures;

use App\Entity\User;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;
use Symfony\Component\PasswordHasher\Hasher\PasswordHasherFactoryInterface;

class UserFixtures extends Fixture
{
    private const USERS = [
        [
            'username' => 'user',
            'password' => 'user',
            'roles' => ['ROLE_USER'],
        ],
        [
            'username' => 'website',
            'password' => 'website',
            'roles' => ['ROLE_WEBSITE'],
        ],
        [
            'username' => 'volunteer',
            'password' => 'volunteer',
            'roles' => ['ROLE_VOLUNTEER'],
        ],
        [
            'username' => 'organizer',
            'password' => 'organizer',
            'roles' => ['ROLE_ORGANIZER'],
        ],
        [
            'username' => 'admin',
            'password' => 'admin',
            'roles' => ['ROLE_ADMIN'],
        ],
    ];

    public function __construct(
        private readonly PasswordHasherFactoryInterface $passwordHasherFactory
    ) {
    }

    public function load(ObjectManager $manager): void
    {
        foreach (self::USERS as $userData) {
            $user = (new User())
                ->setUsername($userData['username'])
                ->setPassword($this->passwordHasherFactory->getPasswordHasher(User::class)->hash($userData['password']))
                ->setRoles($userData['roles'])
            ;

            $this->addReference($userData['username'], $user);
            $manager->persist($user);
        }

        $manager->flush();
    }
}
