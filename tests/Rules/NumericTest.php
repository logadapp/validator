<?php
namespace Rules;

use LogadApp\Validator\Validation;
use PHPUnit\Framework\TestCase;

class NumericTest extends TestCase
{
    public function testWithValidInput()
    {
        $validator = new Validation;
        $rules = [
            'testField' => 'numeric',
        ];
        $validator->validate([
            'testField' => '849',
        ], [], $rules);

        $this->assertTrue($validator->isValid());
    }

    public function testWithInvalidInput()
    {
        $validator = new Validation;
        $rules = [
            'testField' => 'numeric',
        ];
        $validator->validate([
            'testField' => 'string',
        ], [], $rules);

        $this->assertFalse($validator->isValid());
    }
}
