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
     * @param array<string, array<string, mixed>|bool|string> $overwrittenRules - Rules to overwrite
     * @param array<int|string, array<string, mixed>|bool|string> $excludedRules - Rules to exclude from default rules (Useful for risky rules and PHP version specific rules)
     *
     * @return array<string, array<string, mixed>|bool|string>
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
