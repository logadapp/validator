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
}
