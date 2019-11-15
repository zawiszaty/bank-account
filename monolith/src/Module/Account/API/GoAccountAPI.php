<?php
declare(strict_types=1);


namespace App\Module\Account\API;


use App\Module\Account\IO\Account;
use App\Module\Account\IO\AccountCollection;

final class GoAccountAPI implements AccountAPI
{
    private $client;

    public function __construct(GoMonolithClient $client)
    {
        $this->client = $client;
    }

    public function create(): void
    {
        $this->client->create();
    }

    public function addToBalance(string $id, float $amount): void
    {
        $this->client->addToBalance($id, $amount);
    }

    public function getAccounts(): AccountCollection
    {
        $content  = $this->client->getAccounts();
        $accounts = [];

        foreach ($content as $item)
        {
            $accounts[] = new Account((string) $item['Id'], $item['Balance']['Amount']);
        }

        return new AccountCollection($accounts);
    }

    public function withdraw(string $id, float $amount): void
    {
        $this->client->withdraw($id, $amount);
    }

    public function getAccount(string $id): Account
    {
        $content = $this->client->getAccount($id);
        $account = new Account((string) $content['Id'], $content['Balance']['Amount']);

        return $account;
    }
}