<?php
/**
 * Logging related definitions
 *
 * @author wotek <wojtek@kropka.net>
 */
use function DI\object;
use function DI\get;
use function DI\string;

use Interop\Container\ContainerInterface;

return [
    /**
     * Setting up logging
     * https://github.com/Seldaek/monolog/blob/master/doc/01-usage.md
     */
    'log.level' => Monolog\Logger::DEBUG
    , 'log.file.path' => string('{log.path}/{environment}.log')
    /**
     * Logs processors
     */
    , 'log.processor.memory_usage_processor' => object(
        Monolog\Processor\MemoryUsageProcessor::class
    )
    , 'log.processor.web_processor' => object(
        Monolog\Processor\WebProcessor::class
    )
    , 'log.processor.psr_log_message_processor' => object(
        Monolog\Processor\PsrLogMessageProcessor::class
    )
    , 'log.processor.introspection_processor' => object(
        Monolog\Processor\IntrospectionProcessor::class
    )
    /**
     * Log handlers
     */
    , 'log.handler.syslog' => object(Monolog\Handler\SyslogHandler::class)
        ->constructor('app')
        ->method('setFormatter', get('log.formatter.line'))
    , 'log.handler.stream' => object(Monolog\Handler\StreamHandler::class)
            ->constructor(get('log.file.path'), get('log.level'))
    , 'log.formatter.line' => object(Monolog\Formatter\LineFormatter::class)
    /**
     * Logger
     */
    , 'logger' => object(Monolog\Logger::class)
        ->constructor('app')
        ->method('pushHandler', get('log.handler.stream'))
        ->method('pushHandler', get('log.handler.syslog'))
        ->method('pushProcessor', get('log.processor.memory_usage_processor'))
        ->method('pushProcessor', get('log.processor.web_processor'))
        ->method('pushProcessor', get('log.processor.psr_log_message_processor'))
        ->method('pushProcessor', get('log.processor.introspection_processor'))
];
