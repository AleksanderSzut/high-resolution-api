<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateCharactersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('characters', function (Blueprint $table) {
            $table->id();
            $table->uuid('uuid');
            //URL will allow to identify the same characters
            $table->string('url')->unique();
            $table->string("name")->nullable();
            $table->enum('gender', ['female', 'male', 'non-binary'])->nullable();
            $table->string('culture')->nullable();
            $table->string('born')->nullable();
            $table->string('died')->nullable();
            $table->string('father')->nullable();
            $table->string('mother')->nullable();
            $table->string('spouse')->nullable();
            $table->json("titles")->nullable();
            $table->json("aliases")->nullable();
            $table->json("allegiances")->nullable();
            $table->json("books")->nullable();
            $table->json("povBooks")->nullable();
            $table->json("tvSeries")->nullable();
            $table->json("playedBy")->nullable();

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('characters');
    }
}
