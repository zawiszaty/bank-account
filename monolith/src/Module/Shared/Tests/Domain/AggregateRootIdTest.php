<?php

declare(strict_types=1);

namespace App\Module\Shared\Domain;

use PHPUnit\Framework\TestCase;
use Ramsey\Uuid\Uuid;

class AggregateRootIdTest extends TestCase
{
    public function test_it_create_id()
    {
        $aggregateRootId = AggregateRootId::withId(Uuid::uuid4()->toString());
        $this->assertTrue(Uuid::isValid($aggregateRootId->toString()));
    }

    public function test_it_generate_id()
    {
        $aggregateRootId = AggregateRootId::generate();
        $this->assertTrue(Uuid::isValid($aggregateRootId->toString()));
    }
}
