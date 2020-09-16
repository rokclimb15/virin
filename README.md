# VIRIN
A PHP library for validating and parsing [DoD Visual Information Record Identification Number](https://www.dimoc.mil/Submit-DoD-VI/Digital-VI-Toolkit-read-first/Create-a-VIRIN/) (VIRIN)

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

## Parser
```
use Rokclimb15\Virin\Parser;

$parser = new Parser();
$parser->parse('180515-A-AB123-1001');

var_dump($parser->getDateTime());
=> object(DateTime)#735 (3) {
     ["date"]=>
     string(26) "2018-05-15 00:00:00.000000"
     ["timezone_type"]=>
     int(3)
     ["timezone"]=>
     string(3) "UTC"
   }

var_dump($parser->getBranchCode());
=> string(1) "A"

var_dump($parser->getVisionIdOrDvian());
=> string(5) "AB123"

var_dump($parser->getSequence());
=> string(4) "1001"

var_dump($parser->getIso2CountryCode());
=> NULL

var_dump($parser->hasVisionId());
=> bool(true)

var_dump($parser->hasDvian());
=> bool(false)
```
