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
    'text' => 'required|maxLength:5|minLength:3',
    'email' => 'required|email',
    'type' => 'required|in:user,admin',
    'name' => 'requiredIf:type,user,admin',
    'proPic2' => 'file|requiredIf:type,user,admin|fileSize:1MB|fileType:jpg,png,jpeg',
    'profilePic' => 'file|requiredIf:type,user,admin|fileSize:10KB|fileType:jpg,png,jpeg',
];
$validator->make($_POST, $_FILES, $rules);

try {
    $validator->validate();

    echo 'Is valid?', PHP_EOL;
    var_dump($validator->isValid());
    echo PHP_EOL;

    echo 'Get all errors', PHP_EOL;
    print_r($validator->getErrors());
    echo PHP_EOL;

    echo 'Invalid fields', PHP_EOL;
    print_r($validator->getInvalidFields());
    echo PHP_EOL;

    echo 'Error Messages', PHP_EOL;
    print_r($validator->getErrorMessages());

    echo 'First Error Message', PHP_EOL;
    print_r($validator->getFirstErrorMessage());
} catch (Exception $e) {
    echo $e->getMessage();
}
