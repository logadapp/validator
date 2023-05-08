<?php

use LogadApp\Validator\Validation;
use PHPUnit\Framework\TestCase;

class MultipleRulesTest extends TestCase
{
    public function testMultipleRules()
    {
        $validator = new Validation;
        $rules = [
            'tesField' => 'required|numeric|max:10|min:5',
        ];
        $ruleSet = ['required', 'numeric', 'max:10', 'min:5'];


        $validator->validate([], [], $rules);

        $this->assertIsArray($validator->getRuleSet());

        $this->assertSame($ruleSet, $validator->getRuleSet());
    }
}
