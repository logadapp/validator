<?php

use LogadApp\Validator\Validation;
use PHPUnit\Framework\TestCase;

class MakeTest extends TestCase
{
    private array $rules = [
        'test' => 'required|numeric|max:10|min:5',
        'text' => 'required|maxLength:5|minLength:3',
    ];

    public function testMake()
    {
        $validator = new Validation;
        $validator->make([], [], $this->rules);
        $this->assertSame($this->rules, $validator->getRules());
    }
}
