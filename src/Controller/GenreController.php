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
use Symfony\Component\Validator\Validator\ValidatorInterface;

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
    public function add(Request $request, SerializerInterface $serializer, ValidatorInterface $validator)
    {
        // $data = $request->toArray();
        // $movie = new Movie($data['title'], $data['resume'], new \DateTime($data['released']), $data['duration']);
        try {

            $genre = $serializer->deserialize($request->getContent(), Genre::class, 'json');
        } catch (\Exception $error) {
            return $this->json('Invalid body', 400);
        }

        $errors = $validator->validate($genre);
        if ($errors->count() > 0) {
            return $this->json(['errors' => $errors], 400);
        }
        $this->genrep->persist($genre);

        return $this->json($genre, 201);
    }



    #[Route('/{id}', methods: 'PATCH')]
    public function update(int $id, Request $request, SerializerInterface $serializer,ValidatorInterface $validator)
    {

        $genre = $this->genrep->findById($id);
        if ($genre == null) {
            return $this->json('Resource Not found', 404);
        }
        try {
            $serializer->deserialize($request->getContent(), Genre::class, 'json', [
                'object_to_populate' => $genre
            ]);
        } catch (\Exception $error) {
            return $this->json('Invalid body', 400);
        }
        $errors = $validator->validate($genre);
        if ($errors->count() > 0) {
            return $this->json(['errors' => $errors], 400);
        }
        $this->genrep->update($genre);

        return $this->json($genre);
    }




    // Dans le GenreController, rajouter une route sur localhost:8000/api/genre/movie/{id} qui utilisera le findByMovie du GenreRepository
//  pour renvoyer les genres associés à un film donné

    #[Route('/movie/{id}', methods: 'GET')]
    public function findGenreMovie(int $id): JsonResponse
    {

        $genreMovie = $this->genrep->findByMovie($id);
        return $this->json($genreMovie);

    }
}