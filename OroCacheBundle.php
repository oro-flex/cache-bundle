<?php

namespace Oro\Bundle\CacheBundle;

use Oro\Bundle\CacheBundle\DependencyInjection\Compiler\CacheConfigurationPass;
use Oro\Bundle\CacheBundle\DependencyInjection\Compiler\RemoveOrphanServicesPass;
use Oro\Bundle\CacheBundle\DependencyInjection\Compiler\ValidateCacheConfigurationPass;
use Symfony\Component\DependencyInjection\Compiler\PassConfig;
use Symfony\Component\DependencyInjection\ContainerBuilder;
use Symfony\Component\HttpKernel\Bundle\Bundle;

/**
 * The CacheBundle bundle class.
 */
class OroCacheBundle extends Bundle
{
    /**
     * {@inheritdoc}
     */
    public function build(ContainerBuilder $container)
    {
        parent::build($container);

        // Should be right after Symfony's
        // $container->addCompilerPass(new CachePoolPass(), PassConfig::TYPE_BEFORE_OPTIMIZATION, 32);
        // @see \Symfony\Bundle\FrameworkBundle\FrameworkBundle::build
        $container->addCompilerPass(new CacheConfigurationPass(), PassConfig::TYPE_BEFORE_OPTIMIZATION, 31);
        $container->addCompilerPass(new ValidateCacheConfigurationPass(), PassConfig::TYPE_BEFORE_REMOVING);
        $container->addCompilerPass(new RemoveOrphanServicesPass(), PassConfig::TYPE_BEFORE_OPTIMIZATION, PHP_INT_MAX);
    }
}
