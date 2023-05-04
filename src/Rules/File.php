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

final class File extends Rule
{
    public function validate(string $field, mixed $value, array $file, array $params): array
    {
        return [
            'status' => !empty($file['name']),
            'message' => $field . ' -  is not a file'
        ];
    }
}
