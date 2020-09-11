# VIRIN
A PHP library for validating and parsing [DoD Visual Information Record Identification Number](https://dimoc.mil/Submit-DoD-VI/Digital-VI-Toolkit-read-first/Create-a-VIRIN/) (VIRIN)

# Usage

## Validator
```
<?php

use Rokclimb15\Virin\Validator;

$validator = new Validator();
$isValid = $validator->validate('180201-A-AB123-1001-DE');

var_dump($isValid);
=> bool(true)
```
