<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;
use JetBrains\PhpStorm\Pure;
use App\Helpers\Arr;
use phpDocumentor\Reflection\Types\Boolean;

class Character extends Model
{
    use HasFactory;

    // Eloquent to deserialize it from JSON into a PHP array
    protected $casts = [
        'titles' => 'array', 'aliases' => 'array', 'allegiances' => 'array', 'books' => 'array', 'tvSeries' => 'array', 'povBooks' => 'array', 'playedBy' => 'array'
    ];
    //todo: update php to 8.1 and use enum feature

    private const FEMALE = 'female';
    private const MALE = 'male';
    private const NON_BINARY = 'non-binary';

    protected static array $genderTypes = [
        self::FEMALE, self::MALE, self::NON_BINARY,
    ];

    protected $fillable = ['url', 'name', 'gender', 'culture', 'born', 'died', 'father', 'mother', 'spouse', 'titles', 'aliases', 'allegiances', 'books', 'tvSeries', 'povBooks', 'playedBy', 'books'];

    protected $editable = ['born'];

    #[Pure] protected function setGender(?string $gender): ?string
    {
        if (is_null($gender)) {
            return null;
        }
        return array_key_exists( $gender, self::$genderTypes) ?
            $gender : self::NON_BINARY;
    }

    public static function characterWithThisUrlExists(string $url, ?self &$character): bool
    {
        $character = self::getCharacterByUrl($url);

        return $character !== null;
    }

    public static function getCharacterByUrl(string $url): ?self
    {
        return self::class::where('url', $url)->first();
    }

    protected function setUuid(): void
    {
        $this->uuid = Str::uuid();
    }

    public function getFillableValue(): array
    {
        return Arr::only($this->toArray(), $this->getFillable());
    }


}
