<?php
namespace App\Public\Controller;

use App\Repository\CatsRepository;
use Nyholm\Psr7\Response;
use Psr\Http\Message\ServerRequestInterface;
use Spiral\RoadRunner\Http\PSR7Worker;
use Twig\Environment;
use Twig\Loader\FilesystemLoader;

class CatsController
{

    public function __construct(
        private PSR7Worker $worker,
        private ServerRequestInterface $request,
        private Response $response)
    {
    }

    public function get(): void
    {
        $errors = [];
        // example for set cookie with errors and remove them
        if (isset($_COOKIE['errors']) && $_COOKIE['errors'] !== '') {
            $errors = explode('.', $_COOKIE['errors']);
            $this->response = $this->response->withAddedHeader('Set-Cookie', 'errors=');
        }
        $this->response->getBody()->write($this->getHtml(
            'cats.twig',
            [
                'title' => 'Cats List',
                'result' => (new CatsRepository())->getAll(),
                'errors' => $errors
            ]
        ));
        $this->worker->respond($this->response);
    }

    /**
     * @throws \JsonException
     */
    public function post(): void
    {
        $errors = [];
        if (str_contains($_POST['name'], 'cat')) {
            $errors[] = 'nameExistCat';
        }
        if ($errors === []) {
            // equals to get data from $req->getParsedBody() but we set POST шт index.php
            (new CatsRepository())->create(
                $_POST['name'],
                $_POST['type'],
                $_POST['description'],
                $_POST['specials'],
                $_POST['vaccination']
            );
        }
        $this->response = $this->redirect('/');
        if (count($errors) > 0) {
            // if you use cookie you can set it as header
            $this->response = $this->response->withAddedHeader('Set-Cookie', 'errors=' . implode('.', $errors));
        }
        $this->worker->respond($this->response);
    }

    /**
     * @param string $url
     * @return Response
     */
    private function redirect(string $url): Response
    {
        return new Response(301, ['Location' => $url]);
    }

    /**
     * @param string $viewName
     * @param array $data
     * @return string
     * @throws \Twig\Error\LoaderError
     * @throws \Twig\Error\RuntimeError
     * @throws \Twig\Error\SyntaxError
     */
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