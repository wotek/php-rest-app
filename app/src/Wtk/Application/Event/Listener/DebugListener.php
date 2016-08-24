<?php

namespace Wtk\Application\Event\Listener;

use Psr\Log\LoggerInterface;
use League\Event\EventInterface;
use League\Event\ListenerInterface;
use League\Event\AbstractListener;

/**
 * Debug listener used to log events emitted
 *
 * @author wotek <wojtek@kropka.net>
 */
class DebugListener extends AbstractListener
{
    /**
     * Logger instance
     *
     * @var LoggerInterface
     */
    protected $logger;

    /**
     * Constructor.
     *
     * @param LoggerInterface $logger
     */
    public function __construct(LoggerInterface $logger)
    {
        $this->logger = $logger;
    }

    /**
     * Handle an event.
     *
     * @param EventInterface $event
     *
     * @return void
     */
    public function handle(EventInterface $event)
    {
        $this->logger->info(
            sprintf(
                'Event %s dispatched',
                $event->getName()
            )
        );
    }

}
