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

final class Max extends Rule
{
    public function validate(string $field, mixed $value, array $file, array $params): array
    {
        return [
            'status' => $value <= $params[0],
            'message' => 'Max value must be '.$params[0]
        ];
    }
}
