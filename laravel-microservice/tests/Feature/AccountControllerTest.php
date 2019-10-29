<?php

namespace Tests\Feature;

use App\Account;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class AccountControllerTest extends TestCase
{
    use RefreshDatabase;

    protected function setUp(): void
    {
        parent::setUp();
        $this->seed(\DatabaseSeeder::class);
    }

    public function testCreate()
    {
        $response = $this->put('/api/account');
        $response->assertStatus(200);
        $accounts = Account::all();
        $this->assertCount(11, $accounts);
    }

    public function testAddBalance()
    {
        $id       = Account::all()->first()->id;
        $response = $this->json('POST', "/api/account/$id/add/balance", ['amount' => 200.0]);
        $response->assertStatus(200);
        $account = Account::all()->first();
        $this->assertSame(400.0, $account->balance);
    }

    public function testGetAccounts()
    {
        $response = $this->get("/api/accounts");
        $response->assertStatus(200);
        $response->assertJsonCount(10);
    }

    public function testGetAccount()
    {
        $id       = Account::all()->first()->id;
        $response = $this->get("/api/account/$id");
        $response->assertStatus(200);
        $content = json_decode($response->getContent());
        $this->assertSame(200, $content->balance);
    }
}
