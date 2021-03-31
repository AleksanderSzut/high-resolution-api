<?php

namespace App\Console\Commands;

use App\Services\CharactersService;
use App\Services\CharacterApi\CharacterApiAaoiaf;
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

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();
    }

    private function getUserCount():int {
        return (int)($this->argument('count') ?? 1);
    }

    /**
     * Execute the console command.
     *
     * @return int
     */
    public function handle()
    {
        $characters = new CharactersService(new CharacterApiAaoiaf, 1);
    }
}
