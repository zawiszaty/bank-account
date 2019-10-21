<?php
declare(strict_types=1);


namespace App\Module\Account\Main\Domain\Entity;

use App\Module\Account\Main\Domain\Exception\AccountException;
use PHPUnit\Framework\TestCase;

class BalanceTest extends TestCase
{
    public function test_it_create_balance()
    {
        $balance = Balance::create();
        $this->assertSame((float) 200, $balance->toFloat());
    }

    public function test_it_throw_exception_when_you_try_withdraw_to_much()
    {
        $this->expectException(AccountException::class);
        $balance = Balance::create();
        $balance->withdraw((float) 300);
    }
}
