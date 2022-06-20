<?php

namespace App\Api\Controller;

use App\Repository\CatsRepository;
use Nyholm\Psr7\Response;
use Psr\Http\Message\ServerRequestInterface;
use Spiral\RoadRunner\Http\PSR7Worker;

class ApiCatsController
{
    public function __construct(
        private PSR7Worker $worker,
        private ServerRequestInterface $request,
        private Response $response
    )
    {
    }

    public function get(): void
    {
        $this->response->getBody()->write(json_encode((new CatsRepository())->getAll()));
        $this->worker->respond($this->response);
    }

    public function put()
    {
        // todo
        $data = json_encode((string)$this->request->getBody());
        $this->response->getBody()->write($data);
        $this->worker->respond($this->response);
    }
}