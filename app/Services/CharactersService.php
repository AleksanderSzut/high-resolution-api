<?php

namespace App\Services;

use App\Models\CharacterAdd;
use App\Services\CharacterApi\CharacterApiInterface;

class CharactersService
{
    private object $characterApi;
    private int $count;
    private bool $overwriteExisting;
    private array $characters;

    public int $added = 0, $updated = 0, $unchanged = 0, $rejected = 0;

    public function getCharacters(): void
    {
        $this->characterApi->getAllCharacters($this->count);
        $this->characterApi->callApi();
        $this->characters = $this->characterApi->getResponse();
    }

    public function __construct(CharacterApiInterface $characterApi, int $count = 50, bool $overwriteExisting = false)
    {
        $this->count = $count;
        $this->overwriteExisting = $overwriteExisting;
        $this->characterApi = $characterApi;

        $this->getCharacters();
        $this->saveToDb();

    }

    protected function countCharacter(CharacterAdd $characterObject): void
    {
        switch ($characterObject->getStatus()) {
            case CharacterAdd::STATUS_UNCHANGED:
                $this->unchanged++;
                break;
            case CharacterAdd::STATUS_UPDATED:
                $this->updated++;
                break;
            case CharacterAdd::STATUS_REJECTED:
                $this->rejected++;
                break;
            case CharacterAdd::STATUS_ADDED:
                $this->added++;
                break;
        }
    }

        foreach ($this->characters as $value) {
            //todo: Add a count of added, updated and unadded characters
            $character = new CharacterAdd($value, $this->overwriteExisting);
        }

        return false;
    }

}
