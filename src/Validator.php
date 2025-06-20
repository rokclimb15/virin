<?php

declare(strict_types=1);

namespace Rokclimb15\Virin;

use function preg_match;


class Validator
{
    /**
     * Regular expression pattern for matching a VIRIN.
     */
    protected const VALID_PATTERN = '^[0-9]{6}-[A|D|F|G|H|M|N|O|S|X|Z]-([A-Z]{2}[0-9]{3}|[A-Z][0-9]{4})-[1-9][0-9]{3}(-[A-Z]{2})?$';

    protected $allowThreeDigitFieldFour = false;

    /**
     * Validates that string $virin is a syntactically valid VIRIN
     *
     * @param string $virin
     * @return bool
     */
    public function validate(string $virin): bool
    {
        $pattern = self::VALID_PATTERN;
        if ($this->allowThreeDigitFieldFour) {
            // Allow field 4 to be 3 digits instead of 4
            $pattern = str_replace('-[1-9][0-9]{3}(-[A-Z]{2})?', '-([1-9][0-9]{3}(-[A-Z]{2})?|[0-9]{3})', $pattern);
        }
        return (bool)preg_match('/' . $pattern . '/', $virin);
    }

    public function setAllowThreeDigitFieldFour(bool $allow): void
    {
        $this->allowThreeDigitFieldFour = $allow;
    }

    public function getAllowThreeDigitFieldFour(): bool
    {
        return $this->allowThreeDigitFieldFour;
    }
}