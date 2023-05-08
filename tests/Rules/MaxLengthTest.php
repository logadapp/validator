<?php
namespace Rules;

use LogadApp\Validator\Validation;
use PHPUnit\Framework\TestCase;

class MaxLengthTest extends TestCase
{
    public function testWithValidInput()
    {
        $validator = new Validation;
        $rules = [
            'testField' => 'maxLength:8',
        ];
        $validator->validate([
            'testField' => '1234567',
        ], [], $rules);

        $this->assertTrue($validator->isValid());
    }

    public function testWithInvalidInput()
    {
        $validator = new Validation;
        $rules = [
            'testField' => 'maxLength:8',
        ];
        $validator->validate([
            'testField' => '123456789',
        ], [], $rules);

        $this->assertFalse($validator->isValid());
    }
}
