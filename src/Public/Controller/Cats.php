<?php
namespace App\Public\Controller;

use App\Public\Repository\CatsRepository;
use Nyholm\Psr7\Response;
use Psr\Http\Message\ServerRequestInterface;
use Spiral\RoadRunner\Http\PSR7Worker;
use Twig\Environment;
use Twig\Loader\FilesystemLoader;

class Cats
{

    public function __construct(
        private PSR7Worker $worker,
        private ServerRequestInterface $request,
        private Response $response)
    {
    }

    public function get(): void
    {
        $this->response->getBody()->write($this->getHtml(
            'cats.twig',
            [
                'title' => 'Cats List',
                'result' => (new CatsRepository())->getAll(),
                'errors' => $_COOKIE['errors']
            ]
        ));
        $this->worker->respond($this->response);
    }

    public function post(): void
    {
        $data = json_encode((string)$this->request->getBody());
        $errors = null;
        if ($data['name'] === null || $data['name'] === '') {
            $errors = ['emptyName'];
        }
        if ($errors === null) {
            (new CatsRepository())->create(
                $data['name'],
                $data['type'],
                $data['description'],
                $data['specials'],
                $data['vaccination']
            );
        }
        $this->response = $this->redirect('');
        if ($errors !== null) {
            $this->response = $this->response->withAddedHeader('Set-Cookie', 'errors=' . explode('.', $errors));
        }
        $this->worker->respond($this->response);
    }

    private function redirect(string $url): Response
    {
        return new Response(301, ['Location' => $url]);
    }

    private function getHtml(string $viewName, array $data): string
    {
        $twig = new Environment(
            new FilesystemLoader('../src/Public/View'), [
                'cache' => false,
            ]
        );

        return $twig->render($viewName, $data);
    }

}