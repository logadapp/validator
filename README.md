# Under development!


<br />
<div align="center">

  <h1 align="center">LogadApp\Validator</h1>

  <p align="center">
    <a href="https://github.com/logadapp/validator/issues">Report Bug</a>
    ·
    <a href="https://github.com/logadapp/validator/issues">Request Feature</a>
  </p>
</div>

<!-- ABOUT THE PROJECT -->

## About The Project


Features
- Simple to use
- Supports underscores and camelcase (file_size or fileSize)
- Easy to create your own rules
- File validation
- Min\Max length validation
- Email validation
- File size validation
- Conditional requirements
- Similar to Laravel's validation feature
- Inspired by [Rakit\Validation](https://github.com/rakit/validation)

### Installation

_How to install._

1. Using composer
   ```javascript
   composer require logadapp/validator
   ```
3. Include the generated autoload in your file, See index.php for example

### Usage

```php
<?php

use LogadApp\Validator\Validation;

require('vendor/autoload.php');

$validator = new Validation;
$rules = [
    'test' => 'required|numeric|max:10|min:5',
    'text' => 'required|maxLength:5|minLength:3',
    'email' => 'required|email',
    'type' => 'required|in:user,admin',
    'name' => 'requiredIf:type,user,admin',
    'profilePic' => 'file|requiredIf:type,user,admin|fileSize:10KB|fileType:jpg,png,jpeg',
];
$validator->make($_POST, $_FILES, $rules);

$validator->validate();
```

OR Validate directly

```php
$validator->validate($_POST, $_FILES, $rules);
```

### Built With
- [PHP](https://php.net/)

<!-- CONTRIBUTING -->

## Contributing

Contributions are what make the open source community such an amazing place to learn, inspire, and create. Any contributions you make are **greatly appreciated**.

If you have a suggestion that would make this better, please fork the repo and create a pull request. You can also simply open an issue with the tag "enhancement".
Don't forget to give the project a star! Thanks again!

1. Fork the Project
2. Create your Feature Branch
3. Commit your Changes
4. Push to the Branch
5. Open a Pull Request
6.
