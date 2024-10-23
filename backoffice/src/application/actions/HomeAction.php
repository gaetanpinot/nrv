<?php

namespace nrv\back\application\actions;

use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;

 class HomeAction extends AbstractAction
{


    public function __invoke(ServerRequestInterface $rq, ResponseInterface $rs, array $args): ResponseInterface {
        $this->loger->info("Action home");
        $rs->getBody()->write('Hello World :D');
        return $rs;}

}
