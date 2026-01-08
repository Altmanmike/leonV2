<?php

namespace App\Controller;

use App\Entity\Genre;
use App\Form\GenreFormType;
use App\Repository\GenreRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

final class AdminGenreController extends AbstractController
{
    #[Route('/adminGenre', name: 'app_admin_genre')]
    public function index(GenreRepository $repoG): Response
    {
        $genres = $repoG->findAll();
        
        return $this->render('admin_genre/index.html.twig', [
            'controller_name' => 'AdminGenreController',
            'genres' => $genres
        ]);
    }
    
    #[Route('/voirGenre/{id}', name: 'app_voir_genre')]
    public function voirGenre(GenreRepository $repoG, $id): Response
    {
        $genre = $repoG->find($id);
        
        return $this->render('admin_genre/voirGenre.html.twig', [
            'controller_name' => 'AdminGenreController',
            'genre' => $genre
        ]);
    }

    #[Route('/supprimerGenre/{id}', name: 'app_supprimer_genre')]
    public function supprimerGenre(GenreRepository $repoG, EntityManagerInterface $em, $id): Response
    {        
        try {
            if ($repoG->find($id)) {
                $genre = $repoG->find($id);
                $em->remove($genre);
                $em->flush();
                
                $this->addFlash('success', 'Genre retiré.');
                return $this->redirectToRoute('app_admin_genre'); 
            }            

        } catch (\Exception $e) {
            $this->addFlash('error', $e->getMessage());
            return $this->redirectToRoute('app_admin_genre');
        }
                
        return $this->redirectToRoute('app_admin_genre');
    }

    #[Route('/ajouterGenre', name: 'app_ajouter_genre')]
    public function ajouterGenre(EntityManagerInterface $em, Request $request): Response
    {
        $genre = new Genre();
        $form = $this->createForm(GenreFormType::class, $genre);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {

            try {
                $genre->setTitre(htmlspecialchars(trim($form->get('titre')->getData())));               
                
                $em->persist($genre);
                $em->flush();
                $this->addFlash('success', 'Genre enregistré.');

                return $this->redirectToRoute('app_admin_genre');
                
            } catch (\Exception $e) {
                $this->addFlash('error', $e->getMessage());
                
                return $this->redirectToRoute('app_admin_genre');               
            }
        }
        
        return $this->render('admin_genre/ajouterGenre.html.twig', [
            'controller_name' => 'GenreController',            
            'form' => $form->createView(),
        ]);
    }

    #[Route('/modifierGenre/{id}', name: 'app_modifier_genre')]
    public function modifierGenre(GenreRepository $repoG, EntityManagerInterface $em, Request $request, $id): Response
    {
        $genre = $repoG->find($id);
        
        $form = $this->createForm(GenreFormType::class, $genre);
        $form->handleRequest($request);
        
        if ($form->isSubmitted() && $form->isValid()) {
            
            try {
                if ($form->get('titre')->getData()) {
                    $genre->setTitre(htmlspecialchars(trim($form->get('titre')->getData())));                    
                }
                if ($form->get('films')->getData()) {                    
                    foreach ($form->get('films')->getData() as $value) {
                        $genre->addFilm($value);
                    }
                }
                
                $em->persist($genre);
                $em->flush();
                $this->addFlash('success', 'Genre modifié.');

                return $this->redirectToRoute('app_admin_genre');
                
            } catch (\Exception $e) {
                $this->addFlash('error', $e->getMessage());
                
                return $this->redirectToRoute('app_admin_genre');               
            }
        }
            
        return $this->render('admin_genre/modifierGenre.html.twig', [
            'controller_name' => 'AdminGenreController',
            'genre' => $genre,
            'form' => $form->createView(),
        ]);        
    }
}