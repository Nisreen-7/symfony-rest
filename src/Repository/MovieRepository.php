<?php
namespace App\Repository;

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
        $query = $connection->prepare("insert into movie (title,resume,released,length)VALUES(:title,:resume,:released,:length)");
        $query->bindValue(':title', $data->getTitle());
        $query->bindValue(':resume', $data->getResume());
        $query->bindValue(':released', $data->getReleased()->format('Y-m-d'));
        $query->bindValue(':length', $data->getLength());

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
            return new Movie($line['title'], $line['resume'], new DateTime($line['released']), $line['length'], $line['id']);
        }
        return null;
    }

    public function findAll(): array
    {
        $list = [];
        $connection = Database::getConnection();
        $query = $connection->prepare("select * From movie");
        $query->execute();
        foreach ($query->fetchAll() as $line) {
            $list[] = new Movie($line['title'], $line['resume'], new DateTime($line['released']), $line['length'], $line['id']);
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
        $query = $connection->prepare("update movie set title=:title,resume=:resume,released=:released,length=:length 
        where id=:id");
        $query->bindValue(':title', $data->getTitle());
        $query->bindValue(':resume', $data->getResume());
        $query->bindValue(':released', $data->getReleased()->format('Y-m-d'));
        $query->bindValue(':length', $data->getLength());
        $query->bindValue(':id', $data->getId());

        $query->execute();

    }
}