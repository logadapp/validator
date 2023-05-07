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

    /**
     * Get the validation errors
     *
     * @return array The validation errors
     */
    public function getErrors(): array
    {
        return $this->errors;
    }

    /**
     * Get the validation error messages
     *
     * @return array The validation error messages
     */
    public function getErrorMessages(): array
    {
        return $this->errorMessages;
    }

    /**
     * Get the first validation error message
     *
     * @return string The first validation error message
     */
    public function getFirstErrorMessage(): string
    {
        return $this->errorMessages[0] ?? '';
    }

    /**
     * Get the fields that failed validation
     *
     * @return array The fields that failed validation
     */
    public function getInvalidFields(): array
    {
        return array_keys($this->errors);
    }

    /**
     * Check if the validation passed
     *
     * @return bool Returns true if validation passed, false otherwise
     */
    public function isValid(): bool
    {
        return empty($this->errors);
    }

    /**
     * Set the post data, files and validation rules
     *
     * @param array $post The post data to be validated
     * @param array $files The files to be validated
     * @param array $rules The validation rules
     *
     * @return self
     */
    public function make(array $post, array $files, array $rules):self
    {
        $this->postData = $post;
        $this->files = $files;
        $this->rules = $rules;
        return $this;
    }

    /**
     * Validate the post data and files against the validation rules
     *
     * @param array $post The post data to be validated
     * @param array $files The files to be validated
     * @param array $rules The validation rules
     *
     * @throws Exception
     *
     * @return self
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
     * Validates a single rule for a given field value.
     *
     * @param string $rule The name of the rule to validate.
     * @param string $field The name of the field being validated.
     * @param mixed $value The value of the field being validated.
     * @param array $file An array containing file information for file uploads.
     *
     * @throws Exception If the validation rule class or its `validate` method could not be found.
     * @return void
     */
    private function validateRule(string $rule, string $field, mixed $value, array $file): void
    {
        $params = [];

        if (str_contains($rule, ':')) {
            list($rule, $params) = explode(':', $rule, 2);
            $params = explode(',', $params);
        }

        $methodName = ucfirst(
            str_replace('_', '', $rule) // Allows for underscores (`max_length` or `maxLength`)
        );

       /* echo $field . ' -- ' . $rule, PHP_EOL;
        echo $methodName, PHP_EOL;
        echo PHP_EOL;*/

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
                    $this->addError($field, $validateResult['message']);
                }
            } else {
                // log error
                throw new Exception("Validate method couldn't be called for rule $rule");
            }
        } else {
            throw new Exception("Validation rule not found: $rule");
        }
    }

    private function addError(string $field, mixed $message): void
    {
        $this->errorMessages[] = $field . ' - ' . $message;
        $this->errors[$field][] = $message;
    }
}
