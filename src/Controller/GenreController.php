<?php

namespace App\Controller;

use App\Entity\Genre;
use App\Repository\GenreRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Serializer\SerializerInterface;

#[Route('/api/genre')]

class GenreController extends AbstractController
{
    public function __construct(private GenreRepository $genrep)
    {

    }
    #[Route(methods: 'GET')]
    public function all(): Response
    {
        $genre = $this->genrep->findAll();

        return $this->json($genre);
    }

    #[Route('/{id}', methods: 'GET')]
    public function one(int $id): JsonResponse
    {
        $genre = $this->genrep->findById($id);
        if ($genre == null) {
            return $this->json('Resource Not Found', 404);

        }
        return $this->json($genre);
    }
    #[Route('/{id}', methods: 'DELETE')]
    public function delete(int $id): JsonResponse
    {
        $genre = $this->genrep->findById($id);
        if ($genre == null) {
            return $this->json('Resource Not Found', 404);

        }
        $this->genrep->delete($id);

        return $this->json(null, 204);
    }


    #[Route(methods: 'POST')]
    public function add(Request $request, SerializerInterface $serializer)
    {
        // $data = $request->toArray();
        // $movie = new Movie($data['title'], $data['resume'], new \DateTime($data['released']), $data['duration']);
        $genre = $serializer->deserialize($request->getContent(), Movie::class, 'json');
        $this->genrep->persist($genre);
        return $this->json($genre, 201);

    }

    #[Route('/{id}', methods: 'PATCH')]
    public function update(int $id, Request $request, SerializerInterface $serializer)
    {
        // $data = $request->toArray();
        // $movie = new Movie($data['title'], $data['resume'], new \DateTime($data['released']), $data['duration']);
        $genre = $this->genrep->findById($id);
        if ($genre == null) {
            return $this->json('Resource Not Found', 404);
        }
        $serializer->deserialize($request->getContent(), Genre::class, 'json', [
            'object_to_populate' => $genre
        ]);
        $this->genrep->update($genre);
        return $this->json($genre, 201);

    }
}