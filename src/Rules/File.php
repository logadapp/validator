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

        // Check if upload is okay first
        $uploadIsOkay = (!empty($file['name']) && $file['error'] === UPLOAD_ERR_OK);
        if (!$uploadIsOkay) {
            return [
                'status' => false,
                'message' => 'is not a file'
            ];
        }

        if (!empty($params)) {
            // Min size
            if (isset($params[0]) && isset($params[1])) {
                $subRule = $this->callSubRule('fileSize', $field, $value, $file, [
                    $params[0],
                    $params[1]
                ]);
                if (!$subRule['status']) {
                    return [
                        'status' => false,
                        'message' => $subRule['message']
                    ];
                }
            }

            if (isset($params[3])) {
                $subRule = $this->callSubRule('fileType', $field, $value, $file, [
                    $params[0],
                    $params[1]
                ]);
                if (!$subRule['status']) {
                    return [
                        'status' => false,
                        'message' => $subRule['message']
                    ];
                }
            }
        }

        return [
            'status' => false,
            'message' => 'Incorrect file rule'
        ];
    }
}
