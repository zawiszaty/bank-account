<?php
declare(strict_types=1);


namespace App\Module\Account\Main\Domain\Event;


use App\Module\Shared\Domain\AggregateRootId;
use App\Module\Shared\Domain\Event;

final class AccountWasCreated implements Event
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