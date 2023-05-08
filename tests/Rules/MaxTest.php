<?php
namespace Rules;

use LogadApp\Validator\Validation;
use PHPUnit\Framework\TestCase;

class MaxTest extends TestCase
{
    public function testWithValidInput()
    {
        $validator = new Validation;
        $rules = [
            'testField' => 'max:10',
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
            'testField' => 'max:10',
        ];
        $validator->validate([
            'testField' => '19',
        ], [], $rules);

        $this->assertFalse($validator->isValid());
    }
}
