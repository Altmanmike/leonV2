<?php

namespace App\Controller;

use App\Entity\Film;
use App\Form\FilmFormType;
use App\Repository\FilmRepository;
use App\Repository\GenreRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

final class FilmController extends AbstractController
{
    #[Route('/film/{id}', name: 'app_film')]
    public function index(FilmRepository $repoF, $id): Response
    {
        $film = $repoF->find($id);
        
        return $this->render('film/index.html.twig', [
            'controller_name' => 'FilmController',
            'film' => $film
        ]);
    }

    #[Route('/supprimerFilm/{id}', name: 'app_supprimer_film')]
    public function supprimerFilm(FilmRepository $repoF, $id, EntityManagerInterface $em): Response
    {        
        try {
            if ($repoF->find($id)) {
               $film = $repoF->find($id);
                $em->remove($film);
                $em->flush();
                
                $this->addFlash('success', 'Film retiré.');
                return $this->redirectToRoute('app_accueil'); 
            }            

        } catch (\Exception $e) {
            $this->addFlash('error', $e->getMessage());
            return $this->redirectToRoute('app_accueil');
        }
                
        return $this->redirectToRoute('app_accueil');
    }

    #[Route('/ajouterFilm', name: 'app_ajouter_film')]
    public function ajouterFilm(EntityManagerInterface $em, Request $request): Response
    {
        $film = new Film();
        $form = $this->createForm(FilmFormType::class, $film);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {

            try {
                $film->setTitre(htmlspecialchars(trim($form->get('titre')->getData())));
                $film->setAnnee(htmlspecialchars(trim($form->get('annee')->getData())));
                $film->setImage(htmlspecialchars(trim($form->get('image')->getData())));
                $film->setSynopsis(htmlspecialchars(trim($form->get('synopsis')->getData())));

                $film->setRealisateur($form->get('realisateur')->getData());
                
                foreach ($form->get('genres')->getData() as $value) {
                    $film->addGenre($value);
                }
                
                              
                $film->setCreatedAt(new \DatetimeImmutable());
                $film->setUpdatedAt(new \DatetimeImmutable());                
                
                $em->persist($film);
                $em->flush();
                $this->addFlash('success', 'Film enregistré.');

                return $this->redirectToRoute('app_accueil');
                
            } catch (\Exception $e) {
                $this->addFlash('error', $e->getMessage());
                
                return $this->redirectToRoute('app_accueil');               
            }
        }
        
        return $this->render('film/ajouterFilm.html.twig', [
            'controller_name' => 'FilmController',            
            'form' => $form->createView(),
        ]);
    }

    #[Route('/modifierFilm/{id}', name: 'app_modifier_film')]
    public function modifierFilm(FilmRepository $repoF, GenreRepository $repoG, EntityManagerInterface $em, Request $request, $id): Response
    {        
        $film = $repoF->find($id);
        
        $filmUpdated = new Film();
        $form = $this->createForm(FilmFormType::class, $filmUpdated);
        $form->handleRequest($request);
        
        if ($form->isSubmitted() && $form->isValid()) {
            
            try {
                if ($form->get('titre')->getData()) {
                    $film->setTitre(htmlspecialchars(trim($form->get('titre')->getData())));
                }
                if ($form->get('annee')->getData()) {
                    $film->setAnnee(htmlspecialchars(trim($form->get('annee')->getData())));
                }
                if ($form->get('image')->getData()) {
                    $film->setImage(htmlspecialchars(trim($form->get('image')->getData())));
                }
                if ($form->get('synopsis')->getData()) {
                    $film->setSynopsis(htmlspecialchars(trim($form->get('synopsis')->getData())));
                }
                if ($form->get('realisateur')->getData()) {
                    $film->setRealisateur($form->get('realisateur')->getData());
                }
                if ($form->get('genres')->getData()) {                    
                    foreach ($film->getGenres() as $gId) {
                        $genre = $repoG->find($gId);
                        $film->removeGenre($genre);
                    }
                    foreach ($form->get('genres')->getData() as $value) {
                        $film->addGenre($value);
                    }
                }                              
                
                $film->setUpdatedAt(new \DatetimeImmutable());                
                
                $em->persist($film);
                $em->flush();
                $this->addFlash('success', 'Film enregistré.');

                return $this->redirectToRoute('app_accueil');
                
            } catch (\Exception $e) {
                $this->addFlash('error', $e->getMessage());
                
                return $this->redirectToRoute('app_accueil');               
            }
        }
        
        return $this->render('film/modifierFilm.html.twig', [
            'controller_name' => 'FilmController',            
            'form' => $form->createView(),
            'film' => $film
        ]);
    }
}