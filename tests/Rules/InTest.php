<?php
namespace Rules;

use LogadApp\Validator\Validation;
use PHPUnit\Framework\TestCase;

class InTest extends TestCase
{
    public function testWithValidInput()
    {
        $validator = new Validation;
        $rules = [
            'testField' => 'In:test1,test2,test3',
        ];
        $validator->validate([
            'testField' => 'test1',
        ], [], $rules);

        $this->assertTrue($validator->isValid());
    }

    public function testWithInvalidInput()
    {
        $validator = new Validation;
        $rules = [
            'testField' => 'In:test1,test2,test3',
        ];
        $validator->validate([
            'testField' => 'test',
        ], [], $rules);

        $this->assertFalse($validator->isValid());
    }
}
