<?php
/**
 * Validation class
 * @package validation
 * @version 1.0.0
 * @author Michael Arawole <michael@loogad,net>
 * @link https://www.logad.net
 * @date 20 Apr, 2023 8:30 AM
 */

namespace Logadapp\Validator;

use Exception;

final class Validation
{
    public array $postData;
    public array $files;
    public array $rules;
    private array $errors = [];

    private array $errorArray = [];

    public function getErrors(): array
    {
        return $this->errors;
    }

    public function getFirstError(): string
    {
        return $this->errors[0] ?? '';
    }

    public function getInvalidFields(): array
    {
        return array_keys($this->errorArray);
    }

    public function isValid(): bool
    {
        return empty($this->errors);
    }

    public function make(array $post, array $files, array $rules):self
    {
        $this->postData = $post;
        $this->files = $files;
        $this->rules = $rules;
        return $this;
    }

    /**
     * @throws Exception
     */
    public function validate(array $post = [], array $files = [], array $rules = []): self
    {
        // `make` method has not already been used
        if (isset($rules) && !isset($this->rules)) {
            $this->make($post, $files, $rules);
        }

        foreach ($this->rules as $fieldName => $ruleset) {
            $ruleSets = explode('|', $ruleset);
            foreach ($ruleSets as $rule) {
                $this->validateRule($rule, $fieldName, $this->postData[$fieldName]??'', $this->files[$fieldName]??[]);
            }
        }
        return $this;
    }

    /**
     * @throws Exception
     */
    private function validateRule(string $rule, string $field, mixed $value, mixed $file): void
    {
        $params = [];
        $callback = null;

        if (str_contains($rule, ':')) {
            list($rule, $params) = explode(':', $rule, 2);
            $params = explode(',', $params);
        }

        $methodName = 'validate' . ucfirst(
            str_replace('_', '', $rule) // Allows for underscores (`max_length` or `maxLength`)
        );

        echo $field . ' -- ' . $rule, PHP_EOL;
        echo $methodName, PHP_EOL;
        echo PHP_EOL;

        if (method_exists($this, $methodName)) {
            $callback = [$this, $methodName];
        } elseif (function_exists($methodName)) {
            $callback = $methodName;
        }

        if (is_callable($callback)) {
            $validateResult = call_user_func($callback, $field, $value, $file, $params);
            if (!$validateResult['status']) {
                $this->errors[] = $validateResult['message'];
                $this->errorArray[$field] = $validateResult['message'];
            }
        } else {
            // log error
            // throw new Exception("Validation rule not found: $rule");
        }
    }

    private function validateRequired(string $field, string $value): array
    {
        return [
            'status' => !empty($value),
            'message' => $field . ' - is required'
        ];
    }

    private function validateRequiredIf(string $field, mixed $value, array $file, array $params): array
    {
        $requiredField = $params[0];
        $status = false;

        if (isset($this->postData[$requiredField])) {
            $status = in_array($this->postData[$requiredField], array_slice($params, 1));
        }

        return [
            'status' => !($status && empty($value)),
            'message' => $field . ' -  is required'
        ];
    }

    private function validateMin(string $field, int $value, array $file, array $params): array
    {
        return [
            'status' => $value >= $params[0],
            'message' => $field . ' - Min value must be '.$params[0]
        ];
    }

    private function validateMax(string $field, int $value, array $file, array $params): array
    {
        return [
            'status' => $value <= $params[0],
            'message' => $field . ' - Max value must be '.$params[0]
        ];
    }

    private function validateMinLength(string $field, string $value, array $file, array $params): array
    {
        return [
            'status' => strlen($value) >= $params[0],
            'message' => $field . ' - Min length must be '.$params[0]
        ];
    }

    private function validateMaxLength(string $field, string $value, array $file, array $params): array
    {
        return [
            'status' => strlen($value) <= $params[0],
            'message' => $field . ' - Max length must be '.$params[0]
        ];
    }

    private function validateMaxSize(string $field, string|array $value, array $file, array $params): array
    {
        $maxSize = (int) $params[0];
        $status = false;

        if (isset($file['size'])) {
            $status = $file['size'] <= $maxSize;
        }

        if (is_string($value)) {
            $status = strlen($value) <= $maxSize;
        }

        if (is_array($value)) {
            $status = count($value) <= $maxSize;
        }

        return [
            'status' => $status,
            'message' => $field . ' - Max values is ' . $maxSize
        ];
    }

    private function validateEmail(string $field, string $value): array
    {
        return [
            'status' => (filter_var($value, FILTER_VALIDATE_EMAIL) !== false),
            'message' => $field. ' - Invalid email format'
        ];
    }

    private function validateNumeric(string $field, mixed $value): array
    {
        return [
            'status' => is_numeric($value),
            'message' => $field . ' -  is not numeric'
        ];
    }

    private function validateIn(string $field, mixed $value, array $file, array $params): array
    {
        return [
            'status' => in_array($value, $params),
            'message' => $field . ' -  is not between ' . implode(', ', $params)
        ];
    }

    private function validateFile(string $field, mixed $value, array $file, array $params): array
    {
        return [
            'status' => !empty($file['name']),
            'message' => $field . ' -  is not a file'
        ];
    }

    private function validateFileSize(string $field, mixed $value, array $file, array $params): array
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

    private function validateFileType(string $field, mixed $value, array $file, array $params): array
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
