<?php
/**
 * This is our Container definition
 *
 * Why not XML, YAML and so on you ask?
 * Here is pretty good reasoning:
 * http://php-di.org/news/06-php-di-4-0-new-definitions.html
 *
 * I really did liked YAML definitions, altho in this article
 * we have few valid points that you can't argue with.
 *
 * @author wotek <wojtek@kropka.net>
 */

use function DI\object;
use function DI\get;
use function DI\string;
use function DI\add;
use function DI\link;
use function DI\env;

use Interop\Container\ContainerInterface;

/**
 * How to define it?
 *
 * @link http://php-di.org/doc/php-definitions.html DI definitions docs
 */
return [];
