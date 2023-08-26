<?php

namespace Tests;

use AxaZara\CS\Rules;
use PHPUnit\Framework\TestCase;

/**
 * @todo Tests are incomplete
 *
 * @covers \AxaZara\CS\Rules::getRules
 */
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

        // Check array-rule before replace
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

        // Check array-rule after replace
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
}
