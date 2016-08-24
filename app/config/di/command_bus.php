<?php
/**
 * CommandBus related definitions
 *
 * @author wotek <wojtek@kropka.net>
 */
use function DI\object;
use function DI\get;
use function DI\string;

use Interop\Container\ContainerInterface;

return [
    'command_bus.inflector' =>
        object(League\Tactician\Handler\MethodNameInflector\HandleInflector::class)
    , 'command_bus.locator' => function(ContainerInterface $container) {
        return new Wtk\Application\CommandBus\Handler\Locator\ContainerLocator($container);
    }
    , 'command_bus.name_extractor' =>
        object(League\Tactician\Plugins\NamedCommand\NamedCommandExtractor::class)
    , 'command_bus.middleware.handler' =>
        object(League\Tactician\Handler\CommandHandlerMiddleware::class)
        ->constructor(
            get('command_bus.name_extractor'),
            get('command_bus.locator'),
            get('command_bus.inflector')
        )
    , 'command_bus.middleware.event' => object(League\Tactician\CommandEvents\EventMiddleware::class)
        ->constructor(get('event_emitter'))
    , 'command_bus.middleware.logger.formatter' => object(League\Tactician\Logger\Formatter\ClassPropertiesFormatter::class)
    , 'command_bus.middleware.logger' => object(League\Tactician\Logger\LoggerMiddleware::class)
        ->constructor(
            get('command_bus.middleware.logger.formatter'),
            get('logger')
        )
    , 'command_bus' => function(ContainerInterface $container) {
        $middlewares = [
            $container->get('command_bus.middleware.event'),
            $container->get('command_bus.middleware.logger'),
            $container->get('command_bus.middleware.handler'),
        ];

        return new League\Tactician\CommandBus($middlewares);
    }
];
