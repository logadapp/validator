<?php
namespace Rules;

use LogadApp\Validator\Validation;
use PHPUnit\Framework\TestCase;

class MinTest extends TestCase
{
    public function testWithValidInput()
    {
        $validator = new Validation;
        $rules = [
            'testField' => 'min:10',
        ];
        $validator->validate([
            'testField' => '10',
        ], [], $rules);

        $this->assertTrue($validator->isValid());
    }

    public function testWithInvalidInput()
    {
        $validator = new Validation;
        $rules = [
            'testField' => 'min:10',
        ];
        $validator->validate([
            'testField' => '9',
        ], [], $rules);

        $this->assertFalse($validator->isValid());
    }
}
