<?php
namespace App\Repository;

use App\Entity\Genre;
use App\Entity\Movie;
use DateTime;

/**
 * @return Movie[]| null;
 */
class MovieRepository
{


    public function persist(Movie $data)
    {
        $connection = Database::getConnection();
        $query = $connection->prepare("insert into movie (title,resume,released,duration)VALUES(:title,:resume,:released,:duration)");
        $query->bindValue(':title', $data->getTitle());
        $query->bindValue(':resume', $data->getResume());
        $query->bindValue(':released', $data->getReleased()->format('Y-m-d'));
        $query->bindValue(':duration', $data->getDuration());

        $query->execute();
        //  pour prend id en la main 
        $data->setId($connection->lastInsertId());

    }


    public function findById(int $id): ?Movie
    {
        $connection = Database::getConnection();
        $query = $connection->prepare("select * from movie where id=:id");
        $query->bindValue(':id', $id);
        $query->execute();
        foreach ($query->fetchAll() as $line) {
            return new Movie($line['title'], $line['resume'], new DateTime($line['released']), $line['duration'], $line['id']);
        }
        return null;
    }

    /* //En inversant la condition, un peu moins lisible selon moi*/
    // public function findAll(): array
    // {
    //     $list = [];
    //     $connection = Database::getConnection();
    //     $query = $connection->prepare("select *,movie.id movie_id,genre.id genre_id from movie
    //         left join genre_movie on movie.id = genre_movie.id_movie
    //         left join genre on genre.id = genre_movie.id_genre ");
    //     $query->execute();
    //     /**
    //      * @var ?Movie
    //      */
    //     $previousMovie = null;
    //     foreach ($query->fetchAll() as $line) {
    //         if ($previousMovie != null && $previousMovie->getId() == $line['movie_id']) {
    //             $previousMovie->addGenre(new Genre($line['label'], $line['genre_id']));
    //         } else {
    //             $previousMovie = new Movie($line['title'], $line['resume'], new DateTime($line['released']), $line['duration'], $line['movie_id']);
    //             $list[] = $previousMovie;
    //             if (isset($line['genre_id'])) {
    //                 $previousMovie->addGenre(new Genre($line['label'], $line['genre_id']));

    //             }
    //         }

    //     }
    //     return $list;
    // }

    public function findAll(): array
    {
        $list = [];
        $connection = Database::getConnection();

        $query = $connection->prepare("SELECT *, movie.id movie_id, genre.id genre_id FROM movie 
        LEFT JOIN genre_movie ON movie.id=genre_movie.id_movie
        LEFT JOIN genre ON genre.id=genre_movie.id_genre");

        $query->execute();

        /**
         * @var ?Movie
         */
        $previousMovie = null;
        foreach ($query->fetchAll() as $line) {
            if (empty($previousMovie) || $previousMovie->getId() != $line['movie_id']) {
                $previousMovie = new Movie($line["title"], $line["resume"], new DateTime($line["released"]), $line['duration'], $line["movie_id"]);
                $list[] = $previousMovie;
            }
            if (isset($line['genre_id'])) {
                $previousMovie->addGenre(new Genre($line['label'], $line['genre_id']));
            }
        }

        return $list;
    }
//pour  Méthode alternative
    /**
     * @return Movie[] La liste des movies contenus dans la base de données;
     */
    public function findAllWithoutJoin(): array
    {
        $genreRepo = new GenreRepository();
        $list = [];
        $connection = Database::getConnection();

        $query = $connection->prepare("SELECT * FROM movie");

        $query->execute();

        foreach ($query->fetchAll() as $line) {
            $genres = $genreRepo->findByMovie($line['id']);
            $movie = new Movie($line["title"], $line["resume"], new DateTime($line["released"]), $line['duration'], $line["id"]);
            $movie->setGenre($genres);

            $list[] = $movie;
        }

        return $list;
    }


    public function delete(int $id)
    {
        $connection = Database::getConnection();
        $query = $connection->prepare("delete from movie where id =:id");
        $query->bindValue(':id', $id);
        $query->execute();
    }

    public function update(Movie $data)
    {
        $connection = Database::getConnection();
        $query = $connection->prepare("update movie set title=:title,resume=:resume,released=:released,duration=:duration 
        where id=:id");
        $query->bindValue(':title', $data->getTitle());
        $query->bindValue(':resume', $data->getResume());
        $query->bindValue(':released', $data->getReleased()->format('Y-m-d'));
        $query->bindValue(':duration', $data->getDuration());
        $query->bindValue(':id', $data->getId());

        $query->execute();

    }
}