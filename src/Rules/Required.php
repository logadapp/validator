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

final class Required extends Rule
{
    public function validate(string $field, string $value, array $file): array
    {
        return [
            'status' => !(empty($file['name']) && empty($value)),
            'message' => 'is required'
        ];
    }
}
