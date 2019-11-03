<?php
declare(strict_types=1);


namespace App\UI\CLI\Actions;


use MyCLabs\Enum\Enum;

/**
 * @method static ActionType ADD_ACCOUNT()
 * @method static ActionType ADD_BALANCE()
 * @method static ActionType WITHDRAW()
 * @method static ActionType GET_SINGLE()
 */
final class ActionType extends Enum
{
    const ADD_ACCOUNT = 'Add Account';
    const ADD_BALANCE = 'Add Balance';
    const WITHDRAW    = 'Withdraw';
    const GET_SINGLE  = 'Get Single';
}