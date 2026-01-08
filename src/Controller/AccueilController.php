<?php

namespace App\Controller;

use App\Repository\FilmRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

final class AccueilController extends AbstractController
{
    #[Route('/accueil', name: 'app_accueil')]
    public function index(FilmRepository $repoF): Response
    {
        if ($repoF->findByUpdated()) {
            $films = $repoF->findByUpdated();
            
            return $this->render('accueil/index.html.twig', [
                'controller_name' => 'AccueilController',
                'films' => $films
            ]);
        }
            
        $films = $repoF->findByCreated();
        
        return $this->render('accueil/index.html.twig', [
            'controller_name' => 'AccueilController',
            'films' => $films
        ]);
    }
}