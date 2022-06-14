<?php

namespace App\Api\Controller;

use Psr\Http\Message\ServerRequestInterface;
use Spiral\RoadRunner\Http\PSR7Worker;

class Api
{
    public function __construct(protected PSR7Worker $worker, protected ServerRequestInterface $request)
    {
    }
}