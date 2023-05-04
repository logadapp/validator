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

final class FileType extends Rule
{
    public function validate(string $field, mixed $value, array $file, array $params): array
    {
        $allowedMimes = $params;
        print_r($allowedMimes);
        echo 'File';
        print_r($file);
        $status = false;

        if (isset($file['type'])) {
            $mime = $file['type'];
            foreach ($allowedMimes as $allowedMime) {
                if (str_starts_with($mime, $allowedMime)) {
                    $status = true;
                }
            }
        }

        return [
            'status' => $status,
            'message' => $field . ' - Allowed file types are: ' . implode(', ', $allowedMimes)
        ];
    }
}
