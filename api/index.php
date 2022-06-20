<?php
include_once '../vendor/autoload.php';

use Spiral\RoadRunner;
use Nyholm\Psr7;

$workerBase = RoadRunner\Worker::create();
$psrFactory = new Psr7\Factory\Psr17Factory();

$worker = new RoadRunner\Http\PSR7Worker($workerBase, $psrFactory, $psrFactory, $psrFactory);

while ($req = $worker->waitRequest()) {
    try {
        $_COOKIE = $req->getCookieParams() ?? [];
        $_POST = $req->getParsedBody() ?? [];
        $_GET = $req->getQueryParams() ?? [];
        $_REQUEST = array_merge($_POST, $_GET, $_COOKIE);

        $invokedClass = new \App\Api\Controller\ApiCatsController($worker, $req, new Psr7\Response());
        $method = strtolower($req->getMethod());
        $invokedClass->$method();
    } catch (\Throwable $e) {
        $worker->getWorker()->error($e->getMessage());
    }
}

