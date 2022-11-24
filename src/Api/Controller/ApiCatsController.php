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

    /**
     * Method update cat description by id
     *
     * @throws \JsonException
     */
    public function put(): void
    {
        // get input data. It is equals to php://input
        $data = json_decode((string)$this->request->getBody());

        $data = (new CatsRepository())->update(
            $data->id,
            $data->description,
        );
        $this->response->getBody()->write(json_encode($data));
        $this->worker->respond($this->response);
    }
}