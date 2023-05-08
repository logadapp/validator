<?php
namespace Rules;

use LogadApp\Validator\Validation;
use PHPUnit\Framework\TestCase;

class MinLengthTest extends TestCase
{
    public function testWithValidInput()
    {
        $validator = new Validation;
        $rules = [
            'testField' => 'minLength:10',
        ];
        $validator->validate([
            'testField' => '1234567890',
        ], [], $rules);

        $this->assertTrue($validator->isValid());
    }

    public function testWithInvalidInput()
    {
        $validator = new Validation;
        $rules = [
            'testField' => 'minLength:10',
        ];
        $validator->validate([
            'testField' => '123456789',
        ], [], $rules);

        $this->assertFalse($validator->isValid());
    }
}
