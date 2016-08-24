<?php

namespace Acme\Controller;

use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;

class AcmeController
{
    public function __invoke(ServerRequestInterface $request, array $args)
    {
        return [
            'Hello world'
        ];
    }
}
