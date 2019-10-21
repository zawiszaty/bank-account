<?php
declare(strict_types=1);


namespace App\Module\Shared\Tests\TestDoubles;


use App\Module\Shared\Domain\AggregateRootId;
use App\Module\Shared\Domain\Event;

final class SpyEvent implements Event
{
    /** @var AggregateRootId */
    private $id;

    public function __construct(AggregateRootId $id)
    {
        $this->id = $id;
    }

    public function getId(): AggregateRootId
    {
        return $this->id;
    }
}