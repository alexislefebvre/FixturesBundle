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

/**
 * @author Sullivan Senechal <soullivaneuh@gmail.com>
 *
 * @internal
 */
trait QueryCountClientTrait
{
    public function request(
        string $method,
        string $uri,
        array $parameters = [],
        array $files = [],
        array $server = [],
        string $content = null,
        bool $changeHistory = true
    ) {
        $crawler = parent::request($method, $uri, $parameters, $files, $server, $content, $changeHistory);
        $this->checkQueryCount();

        return $crawler;
    }
}
