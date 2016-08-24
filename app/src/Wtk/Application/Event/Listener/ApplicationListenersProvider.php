<?php

namespace Wtk\Application\Event\Listener;

use League\Event\ListenerAcceptorInterface;
use League\Event\ListenerProviderInterface;
use League\Event\ListenerInterface;

/**
 * Listeners provider
 *
 * @author wotek <wojtek@kropka.net>
 */
class ApplicationListenersProvider implements ListenerProviderInterface
{
    /**
     * Listeners array
     *
     * @var array
     */
    protected $listeners = [];

    /**
     * Attaches listener
     *
     * @param string            $event
     * @param ListenerInterface $listener
     */
    public function addListener(string $event, ListenerInterface $listener)
    {
        $this->listeners[$event][] = $listener;
    }

    /**
     * Provides listeners using $acceptor
     *
     * @param  ListenerAcceptorInterface $acceptor
     * @return void
     */
    public function provideListeners(ListenerAcceptorInterface $acceptor)
    {
        foreach ($this->listeners as $event_name => $listeners) {
            foreach ($listeners as $listener) {
                $acceptor->addListener($event_name, $listener);
            }
        }

        unset($this->listeners);
    }
}
