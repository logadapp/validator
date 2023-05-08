<?php
namespace Rules;

use LogadApp\Validator\Validation;
use PHPUnit\Framework\TestCase;

class FileTest extends TestCase
{
    public function testWithValidInput()
    {
        $validator = new Validation;
        $rules = [
            'testFile' => 'file',
        ];
        $validator->validate([], [
            'testFile' => [
                'name' => 'test.jpg',
                'type' => 'image/jpeg',
                'tmp_name' => 'C:\xampp\tmp\phpB8A4.tmp',
                'error' => 0,
                'size' => 98174,
            ],
        ], $rules);

        $this->assertTrue($validator->isValid());
    }

    public function testWithInvalidInput()
    {
        $validator = new Validation;
        $rules = [
            'testFile' => 'file',
        ];
        $validator->validate([], [], $rules);

        $this->assertFalse($validator->isValid());
    }
}
