<?php
// +------------------------------------------------------------------------+
// | @author        : Michael Arawole (Logad Networks)
// | @author_url    : https://www.logad.net
// | @author_email  : logadscripts@gmail.com
// | @date          : 21 Apr, 2023 8:58 AM
// +------------------------------------------------------------------------+

use LogadApp\Validator\Validation;

require 'vendor/autoload.php';

$validator = new Validation;
$rules = [
    'test' => 'required|numeric|max:10|min:5',
    'text' => 'required|maxLength:5',
    'email' => 'required|email'
];
$validator->make($_POST, $_FILES, $rules);

try {
    $validator->validate();
    echo 'Errors', PHP_EOL;
    print_r($validator->getErrors());

    echo 'First Error', PHP_EOL;
    print_r($validator->getFirstError());
} catch (Exception $e) {
}
