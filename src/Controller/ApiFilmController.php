<?php

namespace App\Controller;

use App\Entity\Film;
use App\Repository\FilmRepository;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\Serializer\SerializerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

final class ApiFilmController extends AbstractController
{
    #[Route('/api-film/{id}', name: 'app_api_film')]
    public function index(FilmRepository $repoF, $id, SerializerInterface $serializer): Response
    {
        $film = $repoF->find($id);        
        $jsonFilm = $serializer->serialize($film, 'json', [
            'groups' => ['film:read'] 
        ]);        
        //dd($jsonFilm);        

        return JsonResponse::fromJsonString($jsonFilm);
    }
}