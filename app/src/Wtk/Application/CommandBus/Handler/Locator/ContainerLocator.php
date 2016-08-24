<?php

namespace Wtk\Application\CommandBus\Handler\Locator;

use League\Tactician\Handler\Locator\HandlerLocator;
use League\Tactician\Exception\MissingHandlerException;
use Interop\Container\ContainerInterface;

/**
 * Locator that uses DI container to find handlers for commands
 *
 * @author wotek <wojtek@kropka.net>
 */
class ContainerLocator implements HandlerLocator
{
    /**
     * DI Container
     *
     * @var ContainerInterface
     */
    protected $container;

    /**
     * Constructor.
     *
     * @param ContainerInterface $container
     */
    public function __construct(ContainerInterface $container)
    {
        $this->container = $container;
    }

    /**
     * Retrieves the handler for a specified command
     *
     * @param string $commandName
     *
     * @return object
     *
     * @throws MissingHandlerException
     */
    public function getHandlerForCommand($commandName)
    {
        if(false === $this->container->has($commandName)) {
            throw MissingHandlerException::forCommand($commandName);
        }

        return $this->container->get($commandName);
    }
}
