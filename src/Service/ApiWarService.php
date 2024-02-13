<?php

namespace App\Service;

use Symfony\Contracts\HttpClient\HttpClientInterface;

class ApiWarService
{
    private const BASE_URL = 'https://swapi.py4e.com/api/people/';
    private const ITEM = 'ITEM';
    private const COLLECTION = 'COLLECTION';

    public function __construct(
        private readonly HttpClientInterface $httpClient

    ){

    }

    public function getCharacters() : array
    {
        return $this->makeRequest(self::COLLECTION);
    }

    public function getCharacter(int $id) : array
    {
        return $this->makeRequest(self::ITEM, $id);
    }

    private function makeRequest(string $type, ?int $id = null): array
    {
        $url = $id ? self::BASE_URL.$id : self::BASE_URL;

        $response = $this->httpClient->request('GET', $url);

        $data = match($type){
            self::COLLECTION => $response->toArray()['results'],
            self::ITEM => $response->toArray(),
        };

        return $data;
    }


}