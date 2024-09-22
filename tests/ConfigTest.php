<?php

declare(strict_types=1);

namespace Tests;

use AxaZara\CS\Config;
use Mockery;
use Mockery\Adapter\Phpunit\MockeryTestCase;
use PhpCsFixer\Config as PhpCsFixerConfig;
use PhpCsFixer\Finder as PhpCsFixerFinder;

class ConfigTest extends MockeryTestCase
{
    public function test_method_return_array(): void
    {
        /** @var PhpCsFixerFinder $finder */
        $finder = Mockery::mock(PhpCsFixerFinder::class);

        $config = Config::createWithFinder($finder);

        $this->assertInstanceOf(PhpCsFixerConfig::class, $config);
    }
}
