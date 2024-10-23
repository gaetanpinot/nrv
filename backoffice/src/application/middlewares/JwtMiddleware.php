<?php

namespace nrv\back\application\middlewares;

use Firebase\JWT\JWT;
use Firebase\JWT\Key;

class JwtMiddleware
{
    protected string $secretKey;

    public function __construct()
    {
        $this->secretKey = getenv('JWT_SECRET_KEY');
    }

    public function __invoke($request, $handler)
    {
        $authHeader = $request->getHeader('Authorization');
        if (!$authHeader) {
            throw new \Exception('Token manquant.');
        }

        $token = str_replace('Bearer ', '', $authHeader[0]);

        try {
            $decoded = JWT::decode($token, new Key($this->secretKey, 'HS256'));
            $request = $request->withAttribute('user', $decoded);
        } catch (\Exception $e) {
            throw new \Exception('Token invalide.');
        }

        return $handler->handle($request);
    }
}
