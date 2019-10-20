<?php
declare(strict_types=1);


namespace App\Module\Shared\Infrastructure\EventStore;


use App\Module\Shared\Domain\AggregateRootId;

final class EventStoreEvent
{
    /** @var AggregateRootId */
    private $id;

    /** @var string */
    private $body;

    /** @var string */
    private $aggregate;

    public function __construct(AggregateRootId $id, string $body, string $aggregate)
    {
        $this->id        = $id;
        $this->body      = $body;
        $this->aggregate = $aggregate;
    }

    public function getId(): AggregateRootId
    {
        return $this->id;
    }

    public function getBody(): string
    {
        return $this->body;
    }

    public function getAggregate(): string
    {
        return $this->aggregate;
    }
}