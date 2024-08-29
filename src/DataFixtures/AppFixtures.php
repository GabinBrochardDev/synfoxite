<?php

namespace App\DataFixtures;

use App\Entity\Guirlande;
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

        $manager->flush();
    }
}
