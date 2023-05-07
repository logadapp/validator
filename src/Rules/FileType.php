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

    /**
     * Validate file mime type
     * This only checks the file extension. Consider using mime_content_type() for more accurate validation
     *
     * @param string $field
     * @param mixed $value
     * @param array $file
     * @param array $params
     * @return array
     */
    public function validate(string $field, mixed $value, array $file, array $params): array
    {
        /*echo 'File '. $field;
        print_r($file);
        echo PHP_EOL;*/
        $status = false;
        $allowedTypes = $params;

        if (isset($file['type'])) {
            // $extension = mime_content_type($file['tmp_name']);
            $extension = pathinfo($file['name'], PATHINFO_EXTENSION);
            $status = in_array($extension, $allowedTypes);
        }

        return [
            'status' => $status,
            'message' => 'Allowed file types are: ' . implode(', ', $allowedTypes)
        ];
    }
}
