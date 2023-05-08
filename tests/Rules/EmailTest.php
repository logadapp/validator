<?php
namespace Rules;

use LogadApp\Validator\Validation;
use PHPUnit\Framework\TestCase;

class EmailTest extends TestCase
{
    public function testWithValidInput()
    {
        $validator = new Validation;
        $rules = [
            'email' => 'email',
        ];
        $validator->validate([
            'email' => 'myvalidemail@domain.com',
        ], [], $rules);

        $this->assertTrue($validator->isValid());
    }

    public function testWithInvalidInput()
    {
        $validator = new Validation;
        $rules = [
            'email' => 'required|email',
        ];
        $validator->validate([
            'email' => 'invalidInput',
        ], [], $rules);

        $this->assertFalse($validator->isValid());
    }
}
