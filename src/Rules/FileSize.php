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
        $maxSize = $this->parseSize($params[0]);
        $status = false;

        if (isset($file['size'])) {
            $status = $file['size'] <= $maxSize;
        }

        return [
            'status' => $status,
            'message' => 'Max file size is ' . $params[0]
        ];
    }

    /**
     * Parse a file size string into bytes
     *
     * Turns 1MB, 500KB, ... to bytes
     *
     * @param string $size File size string, eg. '1MB' or '500KB'
     * @return int|false Returns the file size in bytes, or false if the string is invalid
     */
    private function parseSize(string $size): int|false
    {
        $units = [
            'B' => 0,
            'KB' => 1,
            'MB' => 2,
            'GB' => 3,
        ];

        $matches = [];
        if (preg_match('/^(\d+)\s*([KMGT]?B)$/i', $size, $matches)) {
            $num = (int) $matches[1];
            $unit = strtoupper($matches[2]);
            $exp = $units[$unit];
            return $num * (1024 ** $exp);
        }

        return false;
    }
}
