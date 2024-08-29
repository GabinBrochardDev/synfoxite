<?php

namespace App\DataFixtures;

use App\Entity\Guirlande;
use App\Entity\Grassouillet;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;

class AppFixtures extends Fixture
{
    public function load(ObjectManager $manager): void
    {
        $words = [
            'gris',
            'boisson',
            'anniversaire',
            'musicien',
            'guirlande',
            'diagonale',
            'ferraille',
            'doberman',
            'axe',
            'manille',
            'peur',
            'terrassement',
            'grassouillet',
            'comète',
            'rongeur',
            'vaporiser',
            'bouquet',
            'talisman',
            'rembourrage',
            'or',
        ];

        foreach ($words as $word) {
            $guirlande = new Guirlande();
            $guirlande->setName($word);

            $manager->persist($guirlande);
        }

        // Creating animals
        $animal1 = new Grassouillet();
        $animal1->setName('Elephant');
        $animal1->setImage('image_1.jpg');
        $manager->persist($animal1);

        $animal2 = new Grassouillet();
        $animal2->setName('Sauterelle');
        $animal2->setImage('image_2.jpg');
        $manager->persist($animal2);

        $animal3 = new Grassouillet();
        $animal3->setName('Urubu');
        $animal3->setImage('image_3.jpg');
        $manager->persist($animal3);

        $animal4 = new Grassouillet();
        $animal4->setName('Lapin');
        $animal4->setImage('image_4.jpg');
        $manager->persist($animal4);

        $animal5 = new Grassouillet();
        $animal5->setName('Otarie');
        $animal5->setImage('image_5.jpg');
        $manager->persist($animal5);

        $animal6 = new Grassouillet();
        $animal6->setName('Capucin');
        $animal6->setImage('image_6.jpg');
        $manager->persist($animal6);

        $animal7 = new Grassouillet();
        $animal7->setName('Tortue');
        $animal7->setImage('image_7.jpg');
        $manager->persist($animal7);

        $animal8 = new Grassouillet();
        $animal8->setName('Grizzly');
        $animal8->setImage('image_8.jpg');
        $manager->persist($animal8);

        $animal9 = new Grassouillet();
        $animal9->setName('Iguane');
        $animal9->setImage('image_9.jpg');
        $manager->persist($animal9);

        $animal10 = new Grassouillet();
        $animal10->setName('Raton laveur');
        $animal10->setImage('image_10.jpg');
        $manager->persist($animal10);

        $animal11 = new Grassouillet();
        $animal11->setName('Aardvark');
        $animal11->setImage('image_11.jpg');
        $manager->persist($animal11);

        $animal12 = new Grassouillet();
        $animal12->setName('Lorikeet');
        $animal12->setImage('image_12.jpg');
        $manager->persist($animal12);

        $manager->flush();
    }
}
