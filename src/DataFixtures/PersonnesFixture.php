<?php

namespace App\DataFixtures;

use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;
use App\Entity\Personnes;
use Faker;

class PersonnesFixture extends Fixture
{
    public function load(ObjectManager $manager)
    {
        $faker = Faker\Factory::create('fr_FR');

        for ($i = 0; $i < 100000; $i++) {

            $personne = new Personnes();
            $personne->setNom($faker->name);
            $personne->setAdresse($faker->streetAddress);
            $personne->setVille($faker->city);
            $personne->setCodePostal($faker->postcode);
            $personne->setDescription($faker->text);
            $personne->setEmail($faker->email);
            $manager->persist($personne);
            unset($personne);

        }

        // $product = new Product();
        // $manager->persist($product);

        $manager->flush();
    }
}
