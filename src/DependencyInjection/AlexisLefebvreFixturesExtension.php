<?php

declare(strict_types=1);

/*
 * This file is part of the AlexisLefebvre/FixturesBundle
 *
 * (c) Lukas Kahwe Smith <smith@pooteeweet.org>
 *
 * This source file is subject to the MIT license that is bundled
 * with this source code in the file LICENSE.
 */

namespace AlexisLefebvre\FixturesBundle\DependencyInjection;

use Symfony\Component\Config\FileLocator;
use Symfony\Component\DependencyInjection\ContainerBuilder;
use Symfony\Component\DependencyInjection\Loader\XmlFileLoader;
use Symfony\Component\HttpKernel\DependencyInjection\Extension;

class AlexisLefebvreFixturesExtension extends Extension
{
    /**
     * Loads the services based on your application configuration.
     *
     * @param array            $configs
     * @param ContainerBuilder $container
     */
    public function load(array $configs, ContainerBuilder $container): void
    {
        $config = $this->processConfiguration(new Configuration(), $configs);

        $loader = new XmlFileLoader($container, new FileLocator(__DIR__.'/../Resources/config'));
        $loader->load('commands.xml');
        $loader->load('functional_test.xml');
        $loader->load('database_tools.xml');
        if (interface_exists('Symfony\Component\Validator\Validator\ValidatorInterface')) {
            $loader->load('validator.xml');
        }

        foreach ($config as $key => $value) {
            // If the node is an array,
            // e.g. "alexis_lefebvre_fixtures.query.max_query_count",
            // set the value as
            // "alexis_lefebvre_fixtures.query.max_query_count"
            // instead of an array "alexis_lefebvre_fixtures.query"
            // with a "max_query_count" key.
            if (is_array($value)) {
                foreach ($value as $key2 => $value2) {
                    $container->setParameter($this->getAlias().'.'.$key.
                        '.'.$key2, $value2);
                }
            } else {
                $container->setParameter($this->getAlias().'.'.$key, $value);
            }
        }

        $definition = $container->getDefinition('alexis_lefebvre_fixtures.query.count_client');
        $definition->setShared(false);
    }
}
