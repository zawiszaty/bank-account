<?php

declare(strict_types=1);

namespace App;

use App\UI\CLI\Actions\ActionsManager;
use Symfony\Component\Config\FileLocator;
use Symfony\Component\Console\Application as ConsoleApplication;
use Symfony\Component\DependencyInjection\ContainerBuilder;
use Symfony\Component\DependencyInjection\Loader\YamlFileLoader;
use Symfony\Component\DependencyInjection\TaggedContainerInterface;

final class Application extends ConsoleApplication
{
    /** @var TaggedContainerInterface */
    private $container;
    /** @var string */
    private $env;

    public function __construct(string $env)
    {
        parent::__construct('test', '0');
        $this->env       = $env;
        $this->container = new ContainerBuilder();
        $this->setUpContainer();
    }

    private function setUpContainer(): void
    {
        $loader = new YamlFileLoader($this->container, new FileLocator(__DIR__.'/../config'));
        $loader->load('services.yaml');
        foreach ($this->container->findTaggedServiceIds('console') as $commandId => $command) {
            $this->add($this->container->get($commandId));
        }

        /** @var ActionsManager $actionManager */
        $actionManager = $this->container->get(ActionsManager::class);

        foreach ($this->container->findTaggedServiceIds('action') as $actionId => $action)
        {
            $actionManager->addAction($this->container->get($actionId));
        }
    }
}
