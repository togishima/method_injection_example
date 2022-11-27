<?php

namespace App\Http\Requests;

use Psr\Http\Message\ServerRequestInterface;

class SampleRequest
{
    public readonly ?int $id;

    public function __construct(ServerRequestInterface $request)
    {
        $this->id = array_key_exists('id', $request->getQueryParams()) ? $request->getQueryParams()['id'] : null;
    }
}