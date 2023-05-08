<?php
namespace Rules;

use LogadApp\Validator\Validation;
use PHPUnit\Framework\TestCase;

class RequiredIfTest extends TestCase
{
    public function testWithValidInput()
    {
        $validator = new Validation;
        $rules = [
            'requiredField' => 'required',
            'testField' => 'requiredIf:requiredField,yes',
        ];
        $validator->validate([
            'requiredField' => 'yes',
            'testField' => 'value'
        ], [], $rules);

        $this->assertTrue($validator->isValid());
    }

    public function testWithInvalidInput()
    {
        $validator = new Validation;
        $rules = [
            'requiredField' => 'required',
            'testField' => 'requiredIf:requiredField,yes',
        ];
        $validator->validate([
            'requiredField' => 'yes'
        ], [], $rules);

        $this->assertFalse($validator->isValid());
    }
}
