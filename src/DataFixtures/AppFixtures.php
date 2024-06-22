<?php

namespace App\DataFixtures;

use App\Entity\Category;
use App\Entity\User;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;

class AppFixtures extends Fixture
{
    public function __construct(
        private readonly UserPasswordHasherInterface $hasher
    )
    {}

    public function load(ObjectManager $manager): void
    {
        $faker = \Faker\Factory::create('fr_FR');

        $admin = (new User())
            ->setEmail('bonjour@greg-dev.fr')
            ->setNom('Blémand')
            ->setPrenom('Grégory')
            ->setBirthDate(new \DateTime('1983-02-08'))
            ->setRoles(['ROLE_ADMIN'])
        ;

        $admin->setPassword($this->hasher->hashPassword($admin, 'password'));

        $manager->persist($admin);

        for ($i = 0; $i < 9; $i++) {
            $category = new Category();
            $category
                ->setName($faker->word())
                ->setType($faker->boolean() ? 1 : 0)
                ->setUser($admin)
            ;
            $manager->persist($category);
        }

        // $product = new Product();
        // $manager->persist($product);

        $manager->flush();
    }
}
