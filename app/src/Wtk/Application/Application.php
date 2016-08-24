<?php

namespace Wtk\Application;

use Interop\Container\ContainerInterface;
use League\Event\EmitterAwareInterface;
use League\Event\EmitterAwareTrait;

/**
 * Application
 *
 * @author wotek <wojtek@kropka.net>
 */
class Application implements ApplicationInterface, EmitterAwareInterface
{
    use EmitterAwareTrait;

    /**
     * Environment
     *
     * @var string
     */
    protected $environment = Environment::DEVELOPMENT;

    /**
     * Debug mode
     *
     * @var boolean
     */
    protected $debug = false;

    /**
     * Container
     *
     * @var ContainerInterface
     */
    protected $container;

    /**
     * Constructor do-oh
     *
     * @param ContainerInterface $container DI Container
     */
    public function __construct(ContainerInterface $container)
    {
        /**
         * Set container
         *
         * @var ContainerInterface
         */
        $this->container = $container;
    }

    /**
     * Runs application
     */
    public function run()
    {
        $this->container
            ->get('route.collection')
            ->map('GET', '/', new \Acme\Controller\AcmeController);

        $response = $this->container->get('route.collection')->dispatch(
            $this->container->get('request'),
            $this->container->get('response')
        );

        $this->container->get('response.emitter')->emit($response);
    }
}

