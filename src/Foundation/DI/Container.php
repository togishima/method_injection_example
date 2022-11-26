<?php

namespace App\Foundation\DI;

use DI\Container as DIContainer;
use DI\ContainerBuilder;
use Psr\Container\ContainerInterface;

class Container extends DIContainer
{
    private static ?ContainerInterface $instance = null;

    private function __construct()
    {
    }

    public static function instance(): ContainerInterface
    {
        if (self::$instance === null) {
            $builder = new ContainerBuilder();
            $builder->addDefinitions(__DIR__ . '/config.php');
            self::$instance = $builder->build();
        }
        return self::$instance;
    }
}