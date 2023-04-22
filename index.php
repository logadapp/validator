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
    'test' => 'required|numeric|max:10',
];
$validator->make($_POST, $_FILES, $rules);

$validator->validate();

print_r($validator->getErrors());