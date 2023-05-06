<?php
/**
 * Validation class
 * @package validation
 * @version 1.0.0
 * @author Michael Arawole <michael@logad.net>
 * @link https://apps.logad.net/logadapp/validation
 * @date 20 Apr, 2023 8:30 AM
 */

namespace LogadApp\Validator;

use Exception;

final class Validation
{
    private array $postData;

    private array $files;

    private array $rules;

    private array $errors = [];

    private array $errorMessages = [];

    public function getErrors(): array
    {
        return $this->errors;
    }

    public function getErrorMessages(): array
    {
        return $this->errorMessages;
    }

    public function getFirstErrorMessage(): string
    {
        return $this->errorMessages[0] ?? '';
    }

    public function getInvalidFields(): array
    {
        return array_keys($this->errors);
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
    private function validateRule(string $rule, string $field, mixed $value, array $file): void
    {
        $params = [];
        $callback = null;

        if (str_contains($rule, ':')) {
            list($rule, $params) = explode(':', $rule, 2);
            $params = explode(',', $params);
        }

        $methodName = ucfirst(
            str_replace('_', '', $rule) // Allows for underscores (`max_length` or `maxLength`)
        );

        echo $field . ' -- ' . $rule, PHP_EOL;
        echo $methodName, PHP_EOL;
        echo PHP_EOL;

        /**
         * Rules are separated into different classes with the namespace
         * `LogadApp\Validator\Rules` and the class name is the rule name
        */

        $className = 'LogadApp\Validator\Rules\\' . $methodName;
        if (class_exists($className)) {
            $ruleClass = new $className($this->postData, $this->files);
            $callback = [$ruleClass, 'validate'];

            if (is_callable($callback)) {
                $validateResult = call_user_func($callback, $field, $value, $file, $params);
                if (!$validateResult['status']) {
                    $this->errorMessages[] = $validateResult['message'];
                    $this->errors[$field] = $validateResult['message'];
                }
            } else {
                // log error
                throw new Exception("Validate method couldn't be called for rule $rule");
            }
        } else {
            throw new Exception("Validation rule not found: $rule");
        }
    }
}
