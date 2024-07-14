<?php

namespace Tests;

use AxaZara\CS\Finder;
use PhpCsFixer\Finder as PhpCsFixerFinder;
use PHPUnit\Framework\TestCase;


class FinderTest extends TestCase
{
    public function test_method_return_array(): void
    {
        $directory = __DIR__ . '/../src';
        $finder = Finder::createWithRoutes([$directory]);

        $this->assertInstanceOf(PhpCsFixerFinder::class, $finder);
    }
}
