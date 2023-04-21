<?php
// +------------------------------------------------------------------------+
// | @author        : Michael Arawole (Logad Networks)
// | @author_url    : https://www.logad.net
// | @author_email  : logadscripts@gmail.com
// | @date          : 20 Apr, 2023 8:30 AM
// +------------------------------------------------------------------------+

namespace LogadApp\Validator;

class Validation {
    private $errors = [];

    public function getErrors(): array
    {
        return $this->errors;
    }

    public function getFirstError(): string
    {
        return $this->errors[0];
    }

    public function validate(array $post, array $files, array $rules)
    {
        
    }
}