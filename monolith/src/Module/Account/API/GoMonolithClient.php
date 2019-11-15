<?php
declare(strict_types=1);


namespace App\Module\Account\API;


use GuzzleHttp\Client;
use GuzzleHttp\RequestOptions;
use http\Exception\RuntimeException;
use Symfony\Component\HttpFoundation\Response;

final class GoMonolithClient
{
    /**
     * @var Client
     */
    private $client;

    public function __construct()
    {
        $this->client = new Client([
            'base_uri' => 'http://go/api/',
        ]);
    }

    public function create(): void
    {
        $response = $this->client->put('account');

        if ($response->getStatusCode() !== 204)
        {
            throw new RuntimeException();
        }
    }

    public function getAccount(string $id): array
    {
        $response = $this->client->get("account/$id");

        if ($response->getStatusCode() !== 200)
        {
            throw new RuntimeException();
        }
        $content = \GuzzleHttp\json_decode($response->getBody()->getContents(), true);

        return $content;
    }

    public function getAccounts(): array
    {
        $response = $this->client->get("accounts");

        if ($response->getStatusCode() !== 200)
        {
            throw new RuntimeException();
        }
        $content = \GuzzleHttp\json_decode($response->getBody()->getContents(), true);

        return $content;
    }

    public function addToBalance(string $id, float $amount): void
    {
        $response = $this->client->post("account/$id/add/balance", [
            RequestOptions::JSON => ['amount' => $amount]
        ]);

        if ($response->getStatusCode() !== 200)
        {
            throw new RuntimeException();
        }
    }

    public function withdraw(string $id, float $amount): void
    {
        $response = $this->client->post("account/$id/withdraw/balance", [
            RequestOptions::JSON => ['amount' => $amount]
        ]);

        if ($response->getStatusCode() !== 200)
        {
            throw new RuntimeException();
        }
    }
}