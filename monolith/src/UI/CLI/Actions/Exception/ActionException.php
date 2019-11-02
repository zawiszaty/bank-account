<?php
declare(strict_types=1);


namespace App\UI\CLI\Actions\Exception;


final class ActionException extends \RuntimeException
{
    public static function fromMissingAction(string $action)
    {
        return new static(sprintf('%s is missing', $action));
    }
}