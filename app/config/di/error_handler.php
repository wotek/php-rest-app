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

/**
 * How to define it?
 *
 * @link http://php-di.org/doc/php-definitions.html DI definitions docs
 */
return [
    'error_handler' => object(Whoops\Run::class)
    ->method('pushHandler', object(Whoops\Handler\PrettyPageHandler::class))
];
