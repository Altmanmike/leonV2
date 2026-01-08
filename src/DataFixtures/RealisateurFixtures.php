<?php

namespace App\DataFixtures;

use App\Entity\Realisateur;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;

class RealisateurFixtures extends Fixture
{
    public function load(ObjectManager $manager): void
    {
        $realisateur = new Realisateur();
        $realisateur->setNom('Luc Besson');
        $this->addReference('realisateur_0', $realisateur);            
        $manager->persist($realisateur);

        $realisateur = new Realisateur();
        $realisateur->setNom('Steven Spielberg');
        $this->addReference('realisateur_1', $realisateur);            
        $manager->persist($realisateur);

        $realisateur = new Realisateur();
        $realisateur->setNom('James Cameron');
        $this->addReference('realisateur_2', $realisateur);            
        $manager->persist($realisateur);

        
        $manager->flush();
    }
}