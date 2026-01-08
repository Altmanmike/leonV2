<?php

namespace App\Controller;

use App\Entity\Film;
use App\Repository\FilmRepository;
use Symfony\Component\Serializer\SerializerInterface;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;
use Symfony\Component\Serializer\Normalizer\NormalizerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Serializer\Normalizer\DenormalizerInterface;
use Symfony\Component\Serializer\Normalizer\AbstractObjectNormalizer;

final class ApiFilmController extends AbstractController
{
    #[Route('/api-film/{id}', name: 'app_api_film')]
    public function index(FilmRepository $repoF, $id, SerializerInterface $serializer): Response
    {
        $film = $repoF->find($id);
        //dd($film);
        
        return $this->json($film, 200);
    }
}