<?php
declare(strict_types=1);


namespace App\Module\Account\Main\Domain\Exception;


final class AccountException extends \RuntimeException
{
    public static function fromInvalidBalance(): AccountException
    {
        return new static('Balance is Invalid');
    }
}