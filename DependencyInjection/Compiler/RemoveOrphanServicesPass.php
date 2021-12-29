<?php

declare(strict_types=1);

namespace Oro\Bundle\CacheBundle\DependencyInjection\Compiler;

use Symfony\Component\DependencyInjection\Compiler\CompilerPassInterface;
use Symfony\Component\DependencyInjection\ContainerBuilder;

class RemoveOrphanServicesPass implements CompilerPassInterface
{
    /**
     * @inheritDoc
     */
    public function process(ContainerBuilder $container)
    {
        $this->cleanCronBundleDependency($container);
    }

    private function cleanCronBundleDependency(ContainerBuilder $container)
    {
        if (!class_exists('\Oro\Bundle\CronBundle\OroCronBundle')) {
            $this->remove('oro_cache.action.handler.invalidate_scheduled', $container);
            $this->remove('oro_cache.action.handler.schedule_arguments_builder', $container);
            $this->remove('oro_cache.action.provider.invalidate_cache_time', $container);
            $this->remove('Oro\Bundle\CacheBundle\Command\InvalidateCacheScheduleCommand', $container);
        }
    }

    private function remove(string $string, ContainerBuilder $container)
    {
        if ($container->hasDefinition($string)) {
            $container->removeDefinition($string);
        }
    }
}
