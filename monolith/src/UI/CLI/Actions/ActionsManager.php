<?php
declare(strict_types=1);


namespace App\UI\CLI\Actions;


use RuntimeException;
use Symfony\Component\Console\Style\SymfonyStyle;

final class ActionsManager
{
    /**
     * @var ActionInterface[]
     */
    private $actions;

    public function addAction(ActionInterface $action)
    {
        $this->actions[] = $action;
    }

    public function executeAction(Actions $actionName, SymfonyStyle $io): void
    {
        foreach ($this->actions as $action)
        {
            if ($action->supports($actionName))
            {
                $action->execute($io);

                return;
            }
        }

        throw new RuntimeException;
    }
}