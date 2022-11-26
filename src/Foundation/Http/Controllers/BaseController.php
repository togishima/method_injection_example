<?php

namespace App\Foundation\Http\Controllers;

use Psr\Http\Message\ResponseFactoryInterface;
use Psr\Http\Message\StreamFactoryInterface;

class BaseController
{
    private ResponseFactoryInterface $responseFactory;
    private StreamFactoryInterface $streamFactory;

    public function __construct(ResponseFactoryInterface $responseFactory, StreamFactoryInterface $streamFactory)
    {
        $this->responseFactory = $responseFactory;
        $this->streamFactory = $streamFactory;
    }

    public function response(string|array $body, int $statusCode = 200, string $reasonPhrase = '')
    {
        $body = is_string($body) ? $body : json_encode($body, JSON_THROW_ON_ERROR);
        $stream = $this->streamFactory->createStream($body);
        
        return $this->responseFactory
            ->createResponse($statusCode, $reasonPhrase)
            ->withBody($stream);
    }
}