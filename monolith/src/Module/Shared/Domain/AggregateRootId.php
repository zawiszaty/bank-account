<?php
declare(strict_types=1);


namespace App\Module\Shared\Domain;

use Assert\Assertion;
use Ramsey\Uuid\Uuid;
use Ramsey\Uuid\UuidInterface;

final class AggregateRootId extends ValueObject
{
    /** @var UuidInterface */
    private $id;

    public static function withId(string $id): AggregateRootId
    {
        Assertion::uuid($id, 'Id must be uuid');
        $static     = new static();
        $static->id = Uuid::fromString($id);

        return $static;
    }

    public static function generate(): AggregateRootId
    {
        $static     = new static();
        $static->id = Uuid::uuid4();

        return $static;
    }

    public function toString(): string
    {
        return $this->id->toString();
    }
}