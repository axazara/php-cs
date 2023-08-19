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
     * @param array<string, array<string, mixed>|bool> $overwrittenRules
     *
     * @return array<string, array<string, mixed>|bool>
     */
    public static function getRules(array $overwrittenRules = []): array
    {
        $baseRules = require __DIR__ . '/base_rules.php';

        return array_replace_recursive($baseRules, $overwrittenRules);
    }
}
