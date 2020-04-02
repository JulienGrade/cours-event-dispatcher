<?php

use Symfony\Component\DependencyInjection\ContainerBuilder;
use Symfony\Component\DependencyInjection\Loader\YamlFileLoader;
use Symfony\Component\Config\FileLocator;
use App\DependencyInjection\EventCompilerPass;

require __DIR__ . '/../vendor/autoload.php';

$container = new ContainerBuilder();

$loader = new YamlFileLoader($container, new FileLocator(__DIR__));
$loader->load('services.yaml');

$container->addCompilerPass(new EventCompilerPass);

$container->compile();