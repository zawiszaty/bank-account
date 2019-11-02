<?php
declare(strict_types=1);


namespace App\UI\CLI\Actions;


use MyCLabs\Enum\Enum;

/**
 * @method static Actions ADD_ACCOUNT()
 * @method static Actions ADD_BALANCE()
 * @method static Actions WITHDRAW()
 * @method static Actions GET_SINGLE()
 */
final class Actions extends Enum
{
    const ADD_ACCOUNT = 'Add Account';
    const ADD_BALANCE = 'Add Balance';
    const WITHDRAW    = 'Withdraw';
    const GET_SINGLE  = 'Get Single';
}