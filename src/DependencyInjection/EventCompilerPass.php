<?php


namespace App\DependencyInjection;


use Symfony\Component\DependencyInjection\Compiler\CompilerPassInterface;
use Symfony\Component\DependencyInjection\ContainerBuilder;
use Symfony\Component\DependencyInjection\Reference;
use Symfony\Component\EventDispatcher\EventDispatcher;

class EventCompilerPass implements CompilerPassInterface
{

    /**
     * @inheritDoc
     */
    public function process(ContainerBuilder $container)
    {
        // TODO: Implement process() method.
        $subscribersIds = $container->findTaggedServiceIds('app.event_subscriber');

        $dispatcherDefinition = $container->findDefinition(EventDispatcher::class);

        foreach($subscribersIds as $id => $tagData) {
            $dispatcherDefinition->addMethodCall('addSubscriber', [
                new Reference($id)
            ]);
        }

    }
}