<?php

declare(strict_types=1);

namespace Rokclimb15\Virin;

use function preg_match;


class Validator
{
    /**
     * Regular expression pattern for matching a VIRIN.
     */
    protected const VALID_PATTERN = '^[0-9]{6}-[A|D|F|G|H|M|N|O|S|Z]-([A-Z]{2}[0-9]{3}|[A-Z][0-9]{4})-[1-9][0-9]{3}(-[A-Z]{2})?$';

    /**
     * Validates that string $virin is a syntactically valid VIRIN
     *
     * @param string $virin
     * @return bool
     */
    public function validate(string $virin): bool
    {
        return (bool)preg_match('/' . self::VALID_PATTERN . '/', $virin);
    }
}