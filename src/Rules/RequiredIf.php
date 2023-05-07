<?php

/**
 * Required Validator
 * @package validation
 * @version 1.0.0
 * @author Michael Arawole <michael@logad.net>
 * @link https://apps.logad.net/logadapp/validation
 * @date 05 May, 2023 7:20 PM
 */

namespace LogadApp\Validator\Rules;

use LogadApp\Validator\Rule;

final class RequiredIf extends Rule
{
    public function validate(string $field, mixed $value, array $file, array $params): array
    {
        $requiredField = $params[0];
        $status = false;


        if (isset($this->postData[$requiredField])) {
            $status = in_array($this->postData[$requiredField], array_slice($params, 1));
        }

        return [
            'status' => !($status && (empty($file['name']) && empty($value))),
            'message' => 'is required'
        ];
    }
}
