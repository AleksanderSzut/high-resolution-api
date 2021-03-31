<?php

namespace App\Console\Commands;

use App\Services\CharactersService;
use App\Services\CharacterApi\CharacterApiAaoiaf;
use Error;
use Illuminate\Console\Command;

class GetUser extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'get-user {count?}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Downloading people from https://anapioficeandfire.com/ and saving them to the database';

    private function getUserCount():int {
        return (int)($this->argument('count') ?? 1);
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
            new CharactersService(new CharacterApiAaoiaf, $this->getUserCount());
        } catch (Error) {
            return 0;
        }

        return 1;
    }
}
