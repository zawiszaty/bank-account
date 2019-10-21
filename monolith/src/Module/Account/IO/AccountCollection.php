<?php
declare(strict_types=1);


namespace App\Module\Account\IO;


final class AccountCollection
{
    /** @var Account[] */
    private $accounts;

    public function __construct(array $accounts)
    {
        $this->accounts = $accounts;
    }

    public function getAccounts(): array
    {
        return $this->accounts;
    }
}