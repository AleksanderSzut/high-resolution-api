<?php

namespace App\Services\CharacterApi;

use Illuminate\Http\Client\Response;
use Illuminate\Support\Facades\Http;

class CharacterApiAaoiaf implements CharacterApiInterface
{
    private string $url, $path;
    private const URl_PATH = "characters";
    private Response $response;
    // todo:
    public function __construct()
    {
        $this->url = config('characters-api.AAOIAF.host');
    }

    public function urlGenerator(string $params = '', string $characterId = ''): string
    {
        return $this->url . '/' . self::URl_PATH . '/' . $characterId . '?' . $params;
    }

    public function pageSizeParam(int $count): string
    {
        return "pageSize=" . $count;
    }

    public function getAllCharacters($count): void
    {
        $this->path = $this->urlGenerator($this->pageSizeParam($count));
    }

    public function getCharacter(int $id): void
    {
        $this->path = $this->urlGenerator();
    }

    public function callApi(): void
    {
        $this->response = Http::get($this->path);
    }

    public function getResponse(): array
    {
        $json = $this->response->json();

        return is_array($json) ? $json : [];
    }
}
