<?php

declare(strict_types=1);

namespace Tests;

use AxaZara\CS\Rules;
use PHPUnit\Framework\TestCase;

class RulesTest extends TestCase
{
    public function test_method_return_array(): void
    {
        $rules = Rules::getRules();

        $this->assertIsArray($rules);
    }

    public function test_merge_overwritten_rules(): void
    {
        $rules = Rules::getRules();

        $this->assertIsArray($rules);

        $this->assertSame(
            [
                'operators' => [
                    '=>' => 'align',
                ],
            ],
            $rules['binary_operator_spaces']
        );

        $overwrittenRules = ['binary_operator_spaces' => ['default' => 'foo']];
        $rules = Rules::getRules($overwrittenRules);

        $this->assertSame(
            [
                'operators' => [
                    '=>' => 'align',
                ],
                'default' => 'foo',
            ],
            $rules['binary_operator_spaces']
        );
    }

    public function test_excludes_rules(): void
    {
        $rules = Rules::getRules();

        $this->assertIsArray($rules);

        $this->assertSame(
            [
                'elements' => [
                    'method'       => 'one',
                    'property'     => 'one',
                    'const'        => 'one',
                    'trait_import' => 'one',
                ],
            ],
            $rules['class_attributes_separation']
        );

        $excludedRules = ['class_attributes_separation'];

        $rules = Rules::getRules([], $excludedRules);

        $this->assertArrayNotHasKey('class_attributes_separation', $rules);
    }
}
