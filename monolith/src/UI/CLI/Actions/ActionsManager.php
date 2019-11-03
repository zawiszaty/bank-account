<?php
declare(strict_types=1);


namespace App\UI\CLI\Actions;


use App\UI\CLI\Actions\Exception\ActionException;
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

    public function executeAction(ActionType $actionType, SymfonyStyle $io): void
    {
        foreach ($this->actions as $action)
        {
            if ($action->supports($actionType))
            {
                $action->execute($io);

                return;
            }
        }

        throw ActionException::fromMissingAction($actionType->getValue());
    }
}