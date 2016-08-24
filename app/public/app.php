<?php

use Wtk\Application\Bootstrap;
use Composer\Autoload\ClassLoader;

/**
 * Lets define application path
 */
define('APPLICATION_PATH', realpath(dirname(__DIR__)));

/**
 * Autoloader path
 *
 * @var string
 */
$autoload_path = join(
    DIRECTORY_SEPARATOR,
    array(
        APPLICATION_PATH,
        'vendor/autoload.php'
    )
);

/**
 * Require composer autoloader file
 *
 * @var ClassLoader
 */
$loader = require_once $autoload_path;

// @todo: environment and debug flags
$application = (new Bootstrap(APPLICATION_PATH))->createApplication();
$application->run();
