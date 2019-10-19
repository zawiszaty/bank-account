<?php
declare(strict_types=1);


namespace App\Module\Account\IO;


final class Balance
{
    /** @var float */
    private $amount;

    public function __construct(float $amount)
    {
        $this->amount = $amount;
    }

    public function getAmount(): float
    {
        return $this->amount;
    }
}