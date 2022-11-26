<?php

namespace App\Foundation\DI;

use DI\Container as DIContainer;
use DI\ContainerBuilder;
use Psr\Container\ContainerInterface;
use ReflectionMethod;
use ReflectionNamedType;
use ReflectionParameter;

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

    public static function instantiateDependencies(string $className, string $method = '__construct'): array
    {
        $method = new ReflectionMethod($className, $method);
        $parameters = $method->getParameters();
        $dependencies = [];
        /** @var ReflectionParameter $parameter */
        foreach ($parameters as $parameter) {
            $type = $parameter->getType();
            if ($type instanceof ReflectionNamedType) {
                $dependencies[] = self::instance()->get($parameter->getType()->getName());
            }
        }

        return $dependencies;
    }
}