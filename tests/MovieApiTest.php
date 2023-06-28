<?php

namespace App\Tests;

use App\Repository\Database;
use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;

class MovieApiTest extends WebTestCase
{
    public function setUp(): void
    {
        Database::getConnection()->query(file_get_contents(__DIR__ . '/../database.sql'));
    }
    public function testGetAll(): void
    {
        $client = static::createClient();
        $client->request('GET', '/api/movie');
        $json = json_decode($client->getResponse()->getContent(), true);

        $this->assertResponseIsSuccessful();
        $this->assertNotEmpty($json);
        $this->assertIsString($json[0]['title']);
        $this->assertIsInt($json[0]['id']);

    }

    public function testGetAllSuccess(): void
    {
        $client = static::createClient();
        $client->request('GET', '/api/movie');
        $json = json_decode($client->getResponse()->getContent(), true);
        $this->assertResponseIsSuccessful();
        $this->assertNotEmpty($json);
        $this->assertIsString($json[0]['title']);
        $this->assertIsInt($json[0]['id']);

    }

    // Vérifier que le /api/movie/id fonctionne et renvoie bien un truc qui ressemble à un film
    public function testGetOneSuccess(): void
    {
        $client = static::createClient();
        $client->request('GET', '/api/movie/1');
        $json = json_decode($client->getResponse()->getContent(), true);
        $this->assertResponseIsSuccessful();
        $this->assertNotEmpty($json);
        $this->assertIsString($json['title']);
        $this->assertIsString($json['resume']);
        $this->assertIsInt($json['duration']);
        $this->assertIsString($json['released']);
        $this->assertIsInt($json['id']);

    }



    // Vérifier que le /api/movie/id renvoie bien un 404 quand on lui donne un id qui n'existe pas
    public function testGetOneNotFound(): void
    {
        $client = static::createClient();
        $client->request('GET', '/api/movie/100');
        $json = json_decode($client->getResponse()->getContent(), true);
        $this->assertResponseStatusCodeSame(404);

    }



    // Vérifier que le /api/movie en POST fonctionne quand on lui envoie un film en JSON (on pourra par exemple vérifier que la réponse contient bien un id)
    public function testPostSuccess(): void
    {
        $client = static::createClient();
        $client->request('POST', '/api/movie', content: json_encode([
            'title' => 'From test',
            'resume' => 'resume test',
            'released' => '2020-10-01',
            'duration' => 100,

        ]));
        $json = json_decode($client->getResponse()->getContent(), true);
        $this->assertResponseIsSuccessful();

        $this->assertIsInt($json['id']);

    }


    // Vérifier que le /api/movie/id en PATCH fonctionne et met bien à jour le champ qu'on lui dit de modifier
    public function testPatchSuccess(): void
    {
        $client = static::createClient();
        $client->request('PATCH', '/api/movie/2', content: json_encode([
            'title' => 'From test',

        ]));
        $json = json_decode($client->getResponse()->getContent(), true);
        $this->assertResponseIsSuccessful();

        $this->assertEquals($json['title'], 'From test');


    }

    public function testPostValidationFailed(): void
    {
        $client = static::createClient();
        $client->request('POST', '/api/movie', content: json_encode([
            'title' => '',
            'resume' => 'Resume Test',
            'released' => '2020-10-01',
            'duration' => -100
        ]));
        $json = json_decode($client->getResponse()->getContent(), true);

        $this->assertResponseStatusCodeSame(400);

        $this->assertStringContainsString('title', $json['errors']['detail']);
        $this->assertStringContainsString('duration', $json['errors']['detail']);

    }
    // Vérifier qu'on a un 404 sur le PATCH aussi si on donne un truc qui existe pas
    public function testPatchNotFound(): void
    {
        $client = static::createClient();
        $client->request('PATCH', '/api/movie/100');
        $this->assertResponseStatusCodeSame(404);


    }
    // Tester que le /api/movie/id en DELETE fonctionne, mais du coup ça marchera qu'une seule fois pour le moment
    public function testDeleteSuccess(): void
    {
        $client = static::createClient();
        $client->request('DELETE', '/api/movie/1');
        $this->assertResponseIsSuccessful();

    }


}