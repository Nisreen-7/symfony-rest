<?php

namespace App\Controller;

use App\Repository\GenreRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class GenreController extends AbstractController
{
    public function __construct(private GenreRepository $genrep)
    {

    }
    #[Route('/genre')]
    public function index()
    {

        return $this->json();
    }
}
