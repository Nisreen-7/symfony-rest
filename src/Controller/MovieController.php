<?php

namespace App\Controller;

use App\Entity\Movie;
use App\Repository\MovieRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Serializer\SerializerInterface;

#[Route('/api/movie')]
class MovieController extends AbstractController
{
    public function __construct(private MovieRepository $movrep)
    {

    }
    #[Route(methods: 'GET')]
    public function all(): Response
    {
        $movie = $this->movrep->findAll();

        return $this->json($movie);
    }

    #[Route('/{id}', methods: 'GET')]
    public function one(int $id): JsonResponse
    {
        $movie = $this->movrep->findById($id);
        if ($movie == null) {
            return $this->json('Resource Not Found', 404);

        }
        return $this->json($movie);
    }
    #[Route('/{id}', methods: 'DELETE')]
    public function delete(int $id): JsonResponse
    {
        $movie = $this->movrep->findById($id);
        if ($movie == null) {
            return $this->json('Resource Not Found', 404);

        }
        $this->movrep->delete($id);

        return $this->json(null, 204);
    }


    #[Route(methods: 'POST')]
    public function add(Request $request, SerializerInterface $serializer)
    {
        // $data = $request->toArray();
        // $movie = new Movie($data['title'], $data['resume'], new \DateTime($data['released']), $data['length']);
        $movie = $serializer->deserialize($request->getContent(), Movie::class, 'json');
        $this->movrep->persist($movie);
        return $this->json($movie, 201);

    }

    #[Route('/{id}', methods: 'PATCH')]
    public function update(int $id, Request $request, SerializerInterface $serializer)
    {
        // $data = $request->toArray();
        // $movie = new Movie($data['title'], $data['resume'], new \DateTime($data['released']), $data['length']);
        $movie = $this->movrep->findById($id);
        if ($movie == null) {
            return $this->json('Resource Not Found', 404);
        }
        $serializer->deserialize($request->getContent(), Movie::class, 'json', [
            'object_to_populate' => $movie
        ]);
        $this->movrep->update($movie);
        return $this->json($movie, 201);

    }
}