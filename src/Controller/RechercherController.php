<?php

namespace App\Controller;

use App\Repository\FilmRepository;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

final class RechercherController extends AbstractController
{
    #[Route('/rechercher', name: 'app_rechercher')]
    public function index(FilmRepository $repoF, Request $request): Response
    {        
        $data = $request->getContent();       
        $getDataExploded = explode("=", $data); // titre=avatar
                 
        $film = $repoF->findOneBy( [ 'titre' => $getDataExploded ] );
        
        return $this->render('rechercher/index.html.twig', [
            'controller_name' => 'RechercherController',
            'film' => $film
        ]);
    }
}