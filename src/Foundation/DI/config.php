<?php

use Nyholm\Psr7\Factory\Psr17Factory;
use Nyholm\Psr7Server\ServerRequestCreator;
use Nyholm\Psr7Server\ServerRequestCreatorInterface;
use Psr\Container\ContainerInterface;
use Psr\Http\Message\ResponseFactoryInterface;
use Psr\Http\Message\ServerRequestFactoryInterface;
use Psr\Http\Message\ServerRequestInterface;
use Psr\Http\Message\StreamFactoryInterface;
use Psr\Http\Message\UploadedFileFactoryInterface;
use Psr\Http\Message\UriFactoryInterface;

return [
    ServerRequestFactoryInterface::class => fn(ContainerInterface $c) => $c->get(Psr17Factory::class),
    UriFactoryInterface::class => fn(ContainerInterface $c) => $c->get(Psr17Factory::class),
    UploadedFileFactoryInterface::class => fn(ContainerInterface $c) => $c->get(Psr17Factory::class),
    StreamFactoryInterface::class => fn(ContainerInterface $c) => $c->get(Psr17Factory::class),
    ServerRequestCreatorInterface::class => fn(ContainerInterface $c) => $c->get(ServerRequestCreator::class),
    ResponseFactoryInterface::class => fn(ContainerInterface $c) => $c->get(Psr17Factory::class),
    ServerRequestInterface::class => function(ContainerInterface $c) {
        $requestCreator = $c->get(ServerRequestCreatorInterface::class);
        return $requestCreator->fromGlobals();
    }
];