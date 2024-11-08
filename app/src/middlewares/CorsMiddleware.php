<?php

namespace nrv\middlewares;

use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;
use Psr\Http\Server\MiddlewareInterface;
use Psr\Http\Server\RequestHandlerInterface;
use Slim\Routing\RouteContext;

class CorsMiddleware implements MiddlewareInterface{
	
    public function process(ServerRequestInterface $rq, RequestHandlerInterface $handler ): ResponseInterface {
        $routeContext = RouteContext::fromRequest($rq);
        $routingResults = $routeContext->getRoutingResults();
        $methods = $routingResults->getAllowedMethods();
        $resquestHeaders = $rq->getHeaderLine('Access-Control-Request-Headers');

        $origin = $rq->hasHeader('Origin') ? $rq->getHeaderLine('Origin') : '*';

        $response = $handler->handle($rq);

        return $response
            ->withHeader('Access-Control-Allow-Origin', $origin)
            ->withHeader('Access-Control-Allow-Headers', $resquestHeaders)
            ->withHeader('Access-Control-Allow-Methods', implode(', ', $methods))
            ->withHeader('Access-Control-Allow-Credentials', 'true');
    }

}
