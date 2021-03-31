<?php

namespace App\Services\CharacterApi;

interface CharacterApiInterface
{
    public function getCharacter(int $id): void;

    public function getAllCharacters(int $count): void;

    public function getResponse(): array;

    public function callApi(): void;
}
