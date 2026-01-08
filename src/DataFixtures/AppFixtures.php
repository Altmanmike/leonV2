<?php

namespace App\DataFixtures;

use App\Entity\Film;
use App\Entity\Genre;
use App\Entity\Realisateur;
use Doctrine\Persistence\ObjectManager;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\DataFixtures\DependentFixtureInterface;

class AppFixtures extends Fixture implements DependentFixtureInterface
{
    public function load(ObjectManager $manager): void
    {
        $film = new Film();
        $film->setTitre('Avatar')
            ->setAnnee('2007')
            ->setImage('avt.jpeg')
            ->setSynopsis('Grande guerre de pouvoir sur une exoplanète')
            ->setRealisateur($this->getReference('realisateur_2', Realisateur::class))
            ->addGenre($this->getReference('genre_0', Genre::class))
            ->addGenre($this->getReference('genre_2', Genre::class))
            ->addGenre($this->getReference('genre_4', Genre::class))
            ->setCreatedAt(new \DateTimeImmutable())
            ->setUpdatedAt(new \DateTimeImmutable());
        $manager->persist($film);

        $film = new Film();
        $film->setTitre('E.T')
            ->setAnnee('1995')
            ->setImage('et.jpeg')
            ->setSynopsis('Cherche retour à sur sa planète')
            ->setRealisateur($this->getReference('realisateur_1', Realisateur::class))
            ->addGenre($this->getReference('genre_3', Genre::class))
            ->setCreatedAt(new \DateTimeImmutable())
            ->setUpdatedAt(new \DateTimeImmutable());
        $manager->persist($film);

        $film = new Film();
        $film->setTitre('Taxi')
            ->setAnnee('2000')
            ->setImage('tx.jpeg')
            ->setSynopsis('Voiture de courses montées')
            ->setRealisateur($this->getReference('realisateur_0', Realisateur::class))
            ->addGenre($this->getReference('genre_0', Genre::class))
            ->addGenre($this->getReference('genre_1', Genre::class))
            ->setCreatedAt(new \DateTimeImmutable())
            ->setUpdatedAt(new \DateTimeImmutable());
        $manager->persist($film);
        

        $manager->flush();
    }

    public function getDependencies(): array
    {
        return [
            GenreFixtures::class,
            RealisateurFixtures::class
        ]; 
    }
}