<?php
declare(strict_types=1);


namespace App\Module\Shared\Tests\TestDoubles;


use App\Module\Shared\Domain\AggregateRoot;
use App\Module\Shared\Domain\Event;

final class SpyAggregate extends AggregateRoot
{
    public function apply(Event $event): void
    {
        // TODO: Implement apply() method.
    }
}