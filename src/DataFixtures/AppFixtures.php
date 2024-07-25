<?php

namespace App\DataFixtures;

use App\Entity\User;
use Doctrine\Persistence\ObjectManager;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;

class AppFixtures extends Fixture
{
    public function __construct(
        private UserPasswordHasherInterface $hasher
    ) {
    }
    public function load(ObjectManager $manager): void
    {
        // $product = new Product();
        // $manager->persist($product);
        $user = new User();
        $user->setFirstName('Hiba')
            ->setLastName('Babouri')
            ->setEmail('hiba@exemple.com')
            ->setRoles(['ROLE_ADMIN'])
            ->setBirthDate(new \DateTime(('1998-11-28')))
            ->setTelephone('0606060606')
            ->setPassword($this->hasher->hashPassword($user, 'Test1234!'));

        $manager->persist($user);
        $manager->flush();
    }
}
