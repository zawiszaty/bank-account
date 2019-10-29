<?php

declare(strict_types=1);

namespace App\Module\Shared\Infrastructure\EventStore;

use App\Module\Shared\Domain\AggregateRootId;
use App\Module\Shared\Tests\TestDoubles\SpyAggregate;
use App\Module\Shared\Tests\TestDoubles\SpyEvent;
use PHPUnit\Framework\TestCase;

class EventStoreTest extends TestCase
{
    public function testGetAllAggregatesByType()
    {
        $eventStore = new EventStore();
        $eventStore->addEvent(new SpyEvent(AggregateRootId::generate()), SpyAggregate::class);
        $eventStore->addEvent(new SpyEvent(AggregateRootId::generate()), SpyAggregate::class);
        $eventStore->addEvent(new SpyEvent(AggregateRootId::generate()), SpyAggregate::class);
        $aggregates = $eventStore->getAllAggregatesByType(SpyAggregate::class);
        $this->assertCount(3, $aggregates);
    }
}
