<?php

namespace Wtk\Application;

use DI\ContainerBuilder;
use DI\Definition\Source\DefinitionFile;
use Interop\Container\ContainerInterface;
use Wtk\Utils\Path;
use Symfony\Component\Finder\Finder;

/**
 * Bootstrap takes care of Application instantiation and few other
 * minor tasks required to run app, like:
 * - setting up paths
 * - defining values like environment
 * - building DI container
 *
 * @author wotek <wojtek@kropka.net>
 */
final class Bootstrap
{

    /**
     * Application path
     *
     * @var string
     */
    protected $path;

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
     * Application path
     *
     * @param string $application_path
     */
    public function __construct(string $application_path)
    {
        $this->path = $application_path;
    }

    /**
     * Creates Application instance
     *
     * @throws Exception
     *
     * @return ApplicationInterface
     */
    public function createApplication() : ApplicationInterface
    {
        $container = $this->createContainer();

        /**
         * @todo Things below should be done through events. Ie:
         * $this->emitter->emit('application.startup')
         * Meanwhile it's not that complicated. So lets do this explicitly:
         *
         * Also a middleware approach could solve it nicely.
         */

        /**
         * @todo Setup error handling
         *
         * Register error handler
         */
        $container->get('error_handler')->register();

        $application = new Application($container);

        /**
         * Set event emitter
         */
        $application->setEmitter($container->get('event_emitter'));

        /**
         * Attach application listener provider
         * @todo : Move to PHP-DI
         */
        $container->get('event_emitter')->useListenerProvider(
            $container->get('application.listeners.provider')
        );

        return $application;
    }

    /**
     * Creates DI container
     *
     * @return ContainerInterface
     */
    protected function createContainer() : ContainerInterface
    {
        /**
         * Lets create container
         *
         * @var ContainerBuilder
         */
        $builder = new ContainerBuilder;

        /**
         * Disable Autowiring feature
         *
         * @link http://php-di.org/doc/autowiring.html
         */
        $builder->useAutowiring(false);

        /**
         * Disable annotations
         *
         * @link http://php-di.org/doc/annotations.html
         */
        $builder->useAnnotations(false);

        /**
         * @todo Set Container caching using APC Cache
         * $builder->setDefinitionCache($cache);
         * @link http://php-di.org/doc/performances.html
         */

        /**
         * When in prod env enable caching
         */
        // $builder->setDefinitionCache(new \Doctrine\Common\Cache\ApcCache());

        /**
         * Set bare values aka parameters if you come from
         * Symfony universe
         */
        $builder->addDefinitions(
            array(
            'environment'           => $this->environment,
            'debug'                 => $this->debug,
            'application.path'      => $this->path,
            'configuration.path'    => $this->getConfigurationFolderPath(),
            'log.path'              => $this->getLogsPath(),
            )
        );

        /**
         * Feed in container definition
         *
         * @todo Add loding env specific configs
         * @link http://php-di.org/doc/environments.html
         *
         * // Main configuration
         * $builder->addDefinitions("config.php");
         *
         * // Config file for the environment
         * $builder->addDefinitions("config.$environment.php");
         */
        foreach ($this->getContainerDefinitionsFilepaths() as $definition_filepath) {
            $builder->addDefinitions($definition_filepath);
        }

        /**
         * Build container
         *
         * @var ContainerInterface
         */
        return $builder->build();
    }

    /**
     * Returns container definitions files paths
     *
     * @return array An array with service definitions files paths
     */
    protected function getContainerDefinitionsFilepaths() : array
    {
        /**
         * We are using PHP version.
         *
         * @link http://php-di.org/doc/php-definitions.html
         */

        $path = Path::make($this->getConfigurationFolderPath(), 'di');

        $files = [];
        foreach ((new Finder)->files()->name('*.php')->in($path) as $file) {
            $files[] = $file->getPathname();
        }

        return $files;
    }

    /**
     * Returns path to configuration folder
     *
     * @return string
     */
    protected function getConfigurationFolderPath() : string
    {
        return Path::make($this->path, 'config');
    }

    /**
     * Returns path to logs based on current environment setting
     *
     * @return string
     */
    protected function getLogsPath() : string
    {
        return Path::make($this->path, 'var', 'logs');
    }

}
