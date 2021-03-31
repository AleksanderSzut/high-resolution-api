<?php

namespace App\Console\Commands;

use App\Services\CharactersService;
use App\Services\CharacterApi\CharacterApiAaoiaf;
use Error;
use Illuminate\Console\Command;

class GetCharacter extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'get-character {count?}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Downloading people from https://anapioficeandfire.com/ and saving them to the database';

    private function getCharacterCount(): int
    {
        return (int)($this->argument('count') ?? 1);
    }

    private static function getCharactersCountByType(string $type, CharactersService $charactersService): string
    {
        if ($charactersService->$type > 0) {
            return __('console.' . $type, ['count' => $charactersService->$type]);
        }
        return "";
    }

    private function generateSummary(CharactersService $charactersService): string
    {
        $resultMessage = "";

        $resultMessage .= self::getCharactersCountByType('added', $charactersService);
        $resultMessage .= self::getCharactersCountByType('updated', $charactersService);
        $resultMessage .= self::getCharactersCountByType('rejected', $charactersService);
        $resultMessage .= self::getCharactersCountByType('unchanged', $charactersService);

        return $resultMessage;
    }

    /**
     * Execute the console command.
     *
     * @return int
     */
    public function handle(): int
    {
        //todo: adding api selection
        try {
            $characterService = new CharactersService(new CharacterApiAaoiaf, $this->getUserCount());
            $this->generateSummary($characterService);


        } catch (Error) {
            return 0;
        }

        return 1;
    }
}
