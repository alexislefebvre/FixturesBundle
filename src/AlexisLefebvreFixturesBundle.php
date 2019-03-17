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

namespace AlexisLefebvre\FixturesBundle;

use AlexisLefebvre\FixturesBundle\DependencyInjection\Compiler\OptionalValidatorPass;
use AlexisLefebvre\FixturesBundle\DependencyInjection\Compiler\SetTestClientPass;
use Symfony\Component\DependencyInjection\ContainerBuilder;
use Symfony\Component\HttpKernel\Bundle\Bundle;

class AlexisLefebvreFixturesBundle extends Bundle
{
    public function build(ContainerBuilder $container): void
    {
        $container->addCompilerPass(new OptionalValidatorPass());
    }
}
