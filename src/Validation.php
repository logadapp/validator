<?php
// +------------------------------------------------------------------------+
// | @author        : Michael Arawole (Logad Networks)
// | @author_url    : https://www.logad.net
// | @author_email  : logadscripts@gmail.com
// | @date          : 20 Apr, 2023 8:30 AM
// +------------------------------------------------------------------------+

namespace Logadapp\Validator;

use Exception;

final class Validation
{
    public array $postData;
    public array $files;
    public array $rules;
    private array $errors = [];

    public function getErrors(): array
    {
        return $this->errors;
    }

    public function getFirstError(): string
    {
        return $this->errors[0];
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
        // Make method has not already been used
        if (isset($rules) && !isset($this->rules)) {
            $this->make($post, $files, $rules);
        }

        foreach ($this->rules as $fieldName => $ruleset) {
            if (empty($this->postData[$fieldName])) {
                $this->errors[$fieldName][] = 'required';
                continue;
            }

            $ruleSets = explode('|', $ruleset);
            foreach ($ruleSets as $rule) {
                $this->validateRule($rule, $fieldName, $this->postData[$fieldName], $this->files[$fieldName] ?? []);
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

        $methodName = 'validate' . ucfirst($rule);
        echo $methodName, PHP_EOL;
        if (method_exists($this, $methodName)) {
            $callback = [$this, $methodName];
        } elseif (function_exists($methodName)) {
            $callback = $methodName;
        }

        if (is_callable($callback)) {
            if (call_user_func($callback, $field, $value, $file, $params) === false) {
                $this->errors[$field][] = $rule;
            }
        } else {
            throw new Exception("Validation rule not found: $rule");
        }
    }

    private function validateRequired(string $field, string $value)
    {
        return !empty($value);
    }

    private function validateMax(string $field, string|array $value, array $file, array $params): bool
    {
        $maxSize = (int) $params[0];

        if (isset($file['size'])) {
            return $file['size'] <= $maxSize;
        }

        if (is_string($value)) {
            return strlen($value) <= $maxSize;
        }

        if (is_array($value)) {
            return count($value) <= $maxSize;
        }

        return false;
    }

    private function validateEmail(string $value): bool
    {
        return filter_var($value, FILTER_VALIDATE_EMAIL) !== false;
    }

    private function validateNumeric(mixed $value): bool
    {
        return is_numeric($value);
    }

    private function validateMin($value, $params): bool
    {
        return strlen($value) >= $params[0];
    }

    private function validateMimes($field, $value, $file, $params):bool
    {
        $allowedMimes = $params;

        if (isset($file['type'])) {
            $mime = $file['type'];

            foreach ($allowedMimes as $allowedMime) {
                if (str_starts_with($mime, $allowedMime)) {
                    return true;
                }
            }
        }

        return false;
    }
}
