<?php

namespace App\DataFixtures;

use App\Entity\Genre;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;

class GenreFixtures extends Fixture
{
    public function load(ObjectManager $manager): void
    {
        $genre = new Genre();
        $genre->setTitre('Action');
        $this->addReference('genre_0', $genre);
        $manager->persist($genre);

        $genre = new Genre();
        $genre->setTitre('Comédie');
        $this->addReference('genre_1', $genre);
        $manager->persist($genre);

        $genre = new Genre();
        $genre->setTitre('Romantique');
        $this->addReference('genre_2', $genre);
        $manager->persist($genre);

        $genre = new Genre();
        $genre->setTitre('Drame');
        $this->addReference('genre_3', $genre);
        $manager->persist($genre);

        $genre = new Genre();
        $genre->setTitre('Animation');
        $this->addReference('genre_4', $genre);
        $manager->persist($genre);

        
        $manager->flush();
    }
}