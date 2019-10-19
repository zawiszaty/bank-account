<?php
declare(strict_types=1);


namespace App\Module\Account\Main\Domain;

use App\Module\Account\Main\Domain\Event\AccountWasCreated;
use App\Module\Account\Main\Domain\Exception\AccountException;
use PHPUnit\Framework\TestCase;

class AccountTest extends TestCase
{
    public function test_it_create_account_with_starter_balance()
    {
        $account = Account::create();
        $events  = $account->getUnCommittedEvent();
        $this->assertSame((float) 200, $account->getBalance()->toFloat());
        $this->assertInstanceOf(AccountWasCreated::class, $events[0]);
    }

    public function test_it_add_balance_to_account()
    {
        $account = Account::create();
        $account->addBalance((float) 100);
        $this->assertSame((float) 300, $account->getBalance()->toFloat());
    }

    public function test_it_withdraw_from_account()
    {
        $account = Account::create();
        $account->withdraw((float) 100);
        $this->assertSame((float) 100, $account->getBalance()->toFloat());
    }

    public function test_it_throw_exception_when_you_try_withdraw_to_much()
    {
        $this->expectException(AccountException::class);
        $account = Account::create();
        $account->withdraw((float) 300);
    }
}
