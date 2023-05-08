<?php
namespace Rules;

use LogadApp\Validator\Validation;
use PHPUnit\Framework\TestCase;

class RequiredTest extends TestCase
{
    public function testWithValidInput()
    {
        $validator = new Validation;
        $rules = [
            'testField' => 'required',
        ];
        $validator->validate([
            'testField' => 'value',
        ], [], $rules);

        $this->assertTrue($validator->isValid());
    }

    public function testWithInvalidInput()
    {
        $validator = new Validation;
        $rules = [
            'testField' => 'required',
        ];
        $validator->validate([], [], $rules);

        $this->assertFalse($validator->isValid());
    }
}
