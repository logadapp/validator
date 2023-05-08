<?php

use LogadApp\Validator\Validation;
use PHPUnit\Framework\TestCase;

class ValidationTest extends TestCase
{
    public function testValidation()
    {
        $validator = new Validation;
        $rules = [
            'test' => 'required|numeric|max:10|min:5',
            'text' => 'required|maxLength:5|minLength:3',
            'email' => 'required|email',
            'type' => 'required|in:user,admin',
            'name' => 'requiredIf:type,user,admin',
            'proPic2' => 'file|requiredIf:type,user,admin|fileSize:1MB|fileType:jpg,png,jpeg',
            'profilePic' => 'file|requiredIf:type,user,admin|fileSize:10KB|fileType:jpg,png,jpeg',
        ];
        $validator->make($_POST, $_FILES, $rules);

        try {
            $validator->validate();

            $this->assertFalse($validator->isValid());

            $this->assertIsArray($validator->getErrors());

            $this->assertIsArray($validator->getInvalidFields());

            $this->assertIsArray($validator->getErrorMessages());

            $this->assertIsString($validator->getFirstErrorMessage());
        } catch (Exception $e) {
            echo $e->getMessage();
        }
    }
}
