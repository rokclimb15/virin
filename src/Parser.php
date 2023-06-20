<?php

declare(strict_types=1);

namespace Rokclimb15\Virin;

use DateTime;
use Rokclimb15\Virin\Parser\Exception;
use function preg_match;


class Parser
{
    /**
     * Regular expression pattern for parsing a VIRIN.
     */
    protected const CAPTURE_PATTERN = '^([0-9]{6})-([A|D|F|G|H|M|N|O|S|Z])-([A-Z]{2}[0-9]{3}|[A-Z][0-9]{4})-([0-9]{3,4})(?:-([A-Z]{2}))?$';

    protected $field1;
    protected $field2;
    protected $field3;
    protected $field4;
    protected $field5;

    /**
     * Parses valid VIRIN into field components
     *
     * @param string $virin
     * @return array of numeric-indexed matched fields, left-to-right
     * @throws Exception
     */
    public function parse(string $virin): array
    {
        $matches = [];
        $parsed = preg_match('/' . self::CAPTURE_PATTERN . '/', $virin, $matches);

        if (!$parsed) {
            throw new Exception("Unable to parse input VIRIN string (is it syntactically valid?)");
        }

        // Shift the first match off the beginning, it's the full string match
        array_shift($matches);

        // Set the matched parts for retrieval
        $this->field1 = $matches[0];
        $this->field2 = $matches[1];
        $this->field3 = $matches[2];
        $this->field4 = $matches[3];
        $this->field5 = $matches[4] ?? null;

        return $matches;
    }

    public function getDateTime(): DateTime
    {
        // ! omits the current time since this is a date only
        $datetime = DateTime::createFromFormat('!ymd', $this->field1);

        if (checkdate(
                (int) substr($this->field1, 2, 2),
                (int) substr($this->field1, 4, 2),
                (int) substr($this->field1, 0, 2)
            ) === false
        ) {
            throw new Exception("field1 value is not a valid gregorian date string; $this->field1");
        }

        if ($datetime === false) {
            throw new Exception("Unable to convert parsed field1 into DateTime; $this->field1");
        }

        return $datetime;
    }

    public function getBranchCode(): ?string
    {
        return $this->field2;
    }

    public function getVisionIdOrDvian(): ?string
    {
        return $this->field3;
    }

    public function getSequence(): ?string
    {
        return $this->field4;
    }

    public function getIso2CountryCode(): ?string
    {
        return $this->field5;
    }

    public function hasVisionId(): bool
    {
        if ($this->field3 !== null) {
            return ctype_alpha(substr($this->field3, 0, 2));
        }

        return false;
    }

    public function hasDvian(): bool
    {
        if ($this->field3 !== null) {
            return !ctype_alpha(substr($this->field3, 0, 2));
        }

        return false;
    }
}