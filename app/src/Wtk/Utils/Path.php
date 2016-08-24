<?php

namespace Wtk\Utils;

/**
 * Collection of path helpers
 *
 * @author wotek <wojtek@kropka.net>
 */
class Path
{
    /**
     * Helper method to create paths
     *
     * @param  string $parts
     * @return string|false Combines path parts into path and
     *                      treats it with realpath,
     */
    public static function make(string ...$parts)
    {
        return realpath(join(DIRECTORY_SEPARATOR, $parts));
    }
}
