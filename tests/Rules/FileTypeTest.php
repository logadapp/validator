<?php
namespace Rules;

use LogadApp\Validator\Validation;
use PHPUnit\Framework\TestCase;

class FileTypeTest extends TestCase
{
    public function testWithValidInput()
    {
        $validator = new Validation;
        $rules = [
            'testFile' => 'fileType:jpg',
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
            'testFile' => 'fileType:jpg',
        ];
        $validator->validate([], [
            'testFile' => [
                'name' => 'test.png',
                'type' => 'image/png',
                'tmp_name' => 'C:\xampp\tmp\phpB8A4.tmp',
                'error' => 0,
                'size' => 108174,
            ],
        ], $rules);

        $this->assertFalse($validator->isValid());
    }
}
