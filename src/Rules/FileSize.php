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

final class FileSize extends Rule
{
    public function validate(string $field, mixed $value, array $file, array $params): array
    {
        $maxSize = (int) $params[0];
        $status = false;

        if (isset($file['size'])) {
            $status = $file['size'] <= $maxSize;
        }

        return [
            'status' => $status,
            'message' => $field . ' - Max file size is ' . $maxSize
        ];
    }
}
