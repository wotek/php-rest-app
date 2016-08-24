<?php
/**
 * @author wotek <wojtek@kropka.net>
 */

use function DI\object;
use function DI\get;
use function DI\string;
use function DI\add;
use function DI\link;

use Interop\Container\ContainerInterface;

/**
 * How to define it?
 *
 * @link http://php-di.org/doc/php-definitions.html DI definitions docs
 */
return [
    /**
     * Event Emitter
     */
    'event_emitter' => object(League\Event\Emitter::class)
    , 'application.listeners.provider' => object(Wtk\Application\Event\Listener\ApplicationListenersProvider::class)
        ->method('addListener', '*', get('application.listener.debug'))
    , 'application.listener.debug' => object(Wtk\Application\Event\Listener\DebugListener::class)
        ->constructor(get('logger'))
];
