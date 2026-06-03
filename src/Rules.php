<?php

declare(strict_types=1);

namespace AxaZara\CS;

/**
 * The class containing the rules for `php-cs-fixer`.
 *
 * @see https://github.com/FriendsOfPHP/PHP-CS-Fixer
 * @see https://mlocati.github.io/php-cs-fixer-configurator/
 */
class Rules
{
    /**
     * @param array<string, array<string, mixed>|bool> $overwrittenRules - Rules to overwrite
     * @param array<int, string> $excludedRules - Names of rules to exclude from the default set (useful for risky rules and PHP version specific rules)
     *
     * @return array<string, array<string, mixed>|bool>
     */
    public static function getRules(array $overwrittenRules = [], array $excludedRules = [], bool $riskyAllowed = false): array
    {
        $baseRules = require __DIR__ . '/base_rules.php';

        if ($riskyAllowed) {
            $riskyRules = require __DIR__ . '/risk_rules.php';
            $baseRules = array_replace_recursive($baseRules, $riskyRules);
        }

        if ($excludedRules !== []) {
            foreach ($excludedRules as $rule) {
                unset($baseRules[$rule]);
            }
        }

        return array_replace_recursive($baseRules, $overwrittenRules);
    }
}
