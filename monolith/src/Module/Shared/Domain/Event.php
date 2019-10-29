<?php

declare(strict_types=1);

namespace App\Module\Shared\Domain;

interface Event
{
    public function getId(): AggregateRootId;
}
