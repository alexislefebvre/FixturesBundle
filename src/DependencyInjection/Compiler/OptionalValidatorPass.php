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

namespace AlexisLefebvre\FixturesBundle\DependencyInjection\Compiler;

use Symfony\Component\DependencyInjection\Compiler\CompilerPassInterface;
use Symfony\Component\DependencyInjection\ContainerBuilder;

class OptionalValidatorPass implements CompilerPassInterface
{
    public function process(ContainerBuilder $container): void
    {
        if (!$container->hasDefinition('validator')) {
            $container->removeDefinition('alexis_lefebvre_fixtures.validator');
        }
    }
}
