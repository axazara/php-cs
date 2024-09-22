<?php

declare(strict_types=1);

namespace AxaZara\CS;

use PhpCsFixer\Config as PhpCsFixerConfig;
use PhpCsFixer\ConfigInterface;
use PhpCsFixer\Finder as PhpCsFixerFinder;

class Config
{
    /**
     * Creates a new Config.
     *
     * @param array<string, array<string, mixed>|bool> $overwrittenRules - Rules to overwrite
     * @param array<string, array<string, mixed>|bool> $excludedRules - Rules to exclude from default rules (Useful for risky rules and PHP version specific rules)
     * @param bool $riskyAllowed - Whether to allow risky rules
     * @param bool $usingCache - Whether to use cache
     * @param PhpCsFixerFinder $finder - The finder instance
     *
     * @return ConfigInterface - The config instance
     */
    public static function createWithFinder(
        PhpCsFixerFinder $finder,
        array $overwrittenRules = [],
        array $excludedRules = [],
        bool $riskyAllowed = false,
        bool $usingCache = false
    ): ConfigInterface {
        $rules = Rules::getRules($overwrittenRules, $excludedRules, $riskyAllowed);

        return (new PhpCsFixerConfig())
            ->setFinder($finder)
            ->setRules($rules)
            ->setRiskyAllowed($riskyAllowed)
            ->setUsingCache($usingCache);
    }
}
