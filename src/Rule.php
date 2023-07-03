<?php
/**
 * Validation Rules class
 * Routes validation rules to appropriate classes
 * @package validation
 * @version 1.0.0
 * @author Michael Arawole <michael@logad.net>
 * @link https://apps.logad.net/logadapp/validation
 * @date 05 May, 2023 7:20 PM
 */

declare(strict_types=1);

namespace LogadApp\Validator;

class Rule
{
    protected array $postData;
    protected array $files;

    public function __construct(array $postData, array $files)
    {
        $this->postData = $postData;
        $this->files = $files;
    }

    final protected function callSubRule(string $ruleName, string $field, mixed $value, array $file, array $params)
    {
        $className = 'LogadApp\Validator\Rules\\' . $ruleName;
        if (class_exists($className)) {
            $subRule = new $ruleName([], []);
            $result = $subRule->validate($field, $value, $file, [
                $params[0],
                $params[1]
            ]);
            return [
                'status' => $result['status'],
                'message' => $result['message']
            ];
        }

        return [
            'status' => false,
            'message' => 'Invalid sub rule'
        ];
    }
}
