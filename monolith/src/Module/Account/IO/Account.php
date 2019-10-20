<?php
declare(strict_types=1);


namespace App\Module\Account\IO;


final class Account
{
    /** @var string */
    private $id;
    /** @var string */
    private $balance;

    public function __construct(string $id, string $balance)
    {
        $this->id      = $id;
        $this->balance = $balance;
    }

    public function getId(): string
    {
        return $this->id;
    }

    public function getBalance(): string
    {
        return $this->balance;
    }
}