<?php


namespace App\Models;


use App\Helpers\Arr;

class CharacterAdd extends Character
{

    public const STATUS_ADDED = 'added';
    public const STATUS_UPDATED = 'updated';
    public const STATUS_UNCHANGED = 'unchanged';
    public const STATUS_REJECTED = 'rejected';

    public string $status;

    public function getStatus(): string
    {
        return $this->status;
    }

    public function addNewCharacter($value): void
    {
        $character = new parent($value);
        $character->setUuid();

        $this->status = $character->save() ? self::STATUS_ADDED : self::STATUS_REJECTED;
    }

    protected function overwriteCharacterIfThereAreDifferences(array $value): bool
    {
        $characterExistingFillableValue = $this->getFillableValue();

        if (!Arr::compareCaseInsensitive($value, $characterExistingFillableValue)) {
            $this->update($value);
            return true;
        }

        return false;

    }

    public function __construct(array $value, bool $overwriteExisting = false)
    {
        parent::__construct();

        // check user is already exist
        if (self::characterWithThisUrlExists($value['url'], $characterExisting)) {
            if (!$overwriteExisting) {
                $this->status = self::STATUS_REJECTED;
            } else {
                $this->status =
                    $characterExisting->overwriteCharacterIfThereAreDifferences($value) ?
                        self::STATUS_UPDATED : self::STATUS_UNCHANGED;
            }
        } else {
            $this->addNewCharacter($value);
        }

    }

}
