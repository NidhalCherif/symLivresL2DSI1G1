<?php

namespace App\DataFixtures;

use App\Entity\Livres;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;
use Faker\Factory;

class LivresFixtures extends Fixture
{
    public function load(ObjectManager $manager): void
    {  $faker = Factory::create('fr_FR');
        // $faker = Factory::create('ar_SA');
        for ($i=1;$i<=100;$i++)
    {     $livre= new Livres();
          $livre->setLibelle($faker->name())
            ->setPrix(random_int(10,200))
            ->setResume($faker->text())
            ->setEditeur($faker->company())
            ->setDateEdition(new \DateTime('2022-01-01'))
            ->setImage('https://picsum.photos/200/?random='.$i);
        $manager->persist($livre);

    }

$manager->flush();

    }
}
