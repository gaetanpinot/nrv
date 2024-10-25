<?php

namespace nrv\application\middlewares;

use Firebase\JWT\JWT;
use Firebase\JWT\Key;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;
use Psr\Http\Server\RequestHandlerInterface;
use Slim\Exception\HttpUnauthorizedException;

class JwtMiddleware implements \Psr\Http\Server\MiddlewareInterface
{
    protected string $secretKey;

    public function __construct()
    {
        $this->secretKey = getenv('JWT_SECRET_KEY');
    }

    public function process(ServerRequestInterface $request, RequestHandlerInterface $handler): ResponseInterface
    {
        $authHeader = $request->getHeader('Authorization');
        if (!$authHeader) {
            throw new \Exception('Token manquant.');
        }

        $token = str_replace('Bearer ', '', $authHeader[0]);

        try {
            $decoded = JWT::decode($token, new Key($this->secretKey, 'HS256'));
            $request = $request->withAttribute('user', $decoded);
        }   catch (\Firebase\JWT\ExpiredException $e) {
                throw new HttpUnauthorizedException($request, 'expired token.');
        } catch (\Exception $e) {
                throw new HttpUnauthorizedException($request, 'invalid token.');
        }

        return $handler->handle($request);
    }
}
