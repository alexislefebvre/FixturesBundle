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

namespace AlexisLefebvre\FixturesBundle\Tests\Test;

use Doctrine\Bundle\PHPCRBundle\DoctrinePHPCRBundle;
use Doctrine\ORM\Tools\SchemaTool;
use AlexisLefebvre\FixturesBundle\Test\WebTestCase;
use AlexisLefebvre\FixturesBundle\Tests\AppConfigPhpcr\AppConfigPhpcrKernel;

/**
 * Test PHPCR.
 *
 * Use Tests/AppConfigPhpcr/AppConfigMysqlKernel.php instead of
 * Tests/App/AppKernel.php.
 * So it must be loaded in a separate process.
 *
 * @runTestsInSeparateProcesses
 * @preserveGlobalState disabled
 */
class WebTestCaseConfigPhpcrTest extends WebTestCase
{
    protected static function getKernelClass(): string
    {
        return AppConfigPhpcrKernel::class;
    }

    public function setUp(): void
    {
        if (!class_exists(DoctrinePHPCRBundle::class)) {
            $this->markTestSkipped('Need doctrine/phpcr-bundle package.');
        }

        // https://github.com/liip/AlexisLefebvreFixturesBundle#non-sqlite
        $em = $this->getContainer()->get('doctrine')->getManager();
        if (!isset($metadatas)) {
            $metadatas = $em->getMetadataFactory()->getAllMetadata();
        }
        $schemaTool = new SchemaTool($em);
        $schemaTool->dropDatabase();
        if (!empty($metadatas)) {
            $schemaTool->createSchema($metadatas);
        }

        // Needed to define the PHPCR root, used in fixtures.
        $this->runCommand('doctrine:phpcr:repository:init');
    }

    public function testLoadFixturesPhPCr(): void
    {
        $fixtures = $this->loadFixtures([
            'AlexisLefebvre\FixturesBundle\Tests\AppConfigPhpcr\DataFixtures\PHPCR\LoadTaskData',
        ], false, null, 'doctrine_phpcr');

        $this->assertInstanceOf(
            'Doctrine\Bundle\PHPCRBundle\DataFixtures\PHPCRExecutor',
            $fixtures
        );

        $repository = $fixtures->getReferenceRepository();

        $this->assertInstanceOf(
            'Doctrine\Common\DataFixtures\ProxyReferenceRepository',
            $repository
        );
    }
}
