<?php

use AxaZara\CS\Config;
use Mockery\Adapter\Phpunit\MockeryTestCase;
use PhpCsFixer\Config as PhpCsFixerConfig;
use PhpCsFixer\Finder as PhpCsFixerFinder;

/**
 * @covers \AxaZara\CS\Config::createWithFinder
 */
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
