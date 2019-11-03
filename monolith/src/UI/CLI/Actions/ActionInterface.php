<?php
declare(strict_types=1);


namespace App\UI\CLI\Actions;


use Symfony\Component\Console\Style\SymfonyStyle;

interface ActionInterface
{
    public function supports(ActionType $action): bool;

    public function execute(SymfonyStyle $io): void;
}