<?php
declare(strict_types=1);


namespace App\Module\Account\Main\Domain\ValueObject;


use App\Module\Account\Main\Domain\Exception\AccountException;
use App\Module\Shared\Domain\ValueObject;

final class Balance extends ValueObject
{
    /** @var float */
    private $balance;

    public static function create(): self
    {
        $self          = new static();
        $self->balance = (float) 200;

        return $self;
    }

    public function toFloat(): float
    {
        return $this->balance;
    }

    public function withdraw(float $amount): Balance
    {
        if ($this->balance - $amount > 0)
        {
            $self          = new static();
            $self->balance = $this->balance - $amount;

            return $self;
        }

        throw AccountException::fromInvalidBalance();
    }

    public function addBalance(float $amount): self
    {
        $self          = new static();
        $self->balance = $this->balance + $amount;

        return $self;
    }
}