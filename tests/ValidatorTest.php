<?php

declare(strict_types=1);

namespace Rokclimb15\Virin\Test;

use Rokclimb15\Virin\Validator;
use function BenTools\CartesianProduct\cartesian_product;
use PHPUnit\Framework\TestCase as PhpUnitTestCase;

class ValidatorTest extends PhpUnitTestCase
{
    /**
     * @dataProvider valuesForValidation
     * @param string $value
     * @param bool $expected
     */
    public function testValidate(string $value, bool $expected): void
    {
        $validator = new Validator();

        $this->assertSame($expected, $validator->validate($value));
    }

    /**
     * @dataProvider valuesForValidationWithThreeDigitFieldFour
     * @param string $value
     * @param bool $expected
     */
    public function testValidateWithThreeDigitFieldFour(string $value, bool $expected): void
    {
        $validator = new Validator();
        $validator->setAllowThreeDigitFieldFour(true);

        $this->assertSame($expected, $validator->validate($value));
    }

    /**
     * @dataProvider valuesForValidationWithLegacyIdentifier
     * @param string $value
     * @param bool $expected
     */
    public function testValidateWithLegacyIdentifier(string $value, bool $expected): void
    {
        $validator = new Validator();
        $validator->setAllowLegacyIdentifier(true);

        $this->assertSame($expected, $validator->validate($value));
    }

    public static function valuesForValidation(): array
    {
        return array_merge(static::getValidVirinsForValidation(), static::getInvalidVirinsForValidation());
    }

    public static function valuesForValidationWithThreeDigitFieldFour(): array
    {
        return array_merge(static::getValidVirinsForValidation(true), static::getInvalidVirinsForValidation(true));
    }

    public static function valuesForValidationWithLegacyIdentifier(): array
    {
        return array_merge(static::getValidVirinsForValidation(false, true), static::getInvalidVirinsForValidation(false, true));
    }

    protected static function getValidVirinsForValidation(bool $allowThreeDigitFieldFour = false, bool $allowLegacyIdentifier = false): array
    {
        $parts = [
            'field1' => [
                '180515',
            ],
            'field2' => [
                'A',
                'D',
                'F',
                'G',
                'H',
                'M',
                'N',
                'O',
                'S',
                'X',
                'Z',
            ],
            'field3' => [
                'AA987',
                'A0987'
            ],
            'field4' => [
                '1001',
            ],
            'field5' => [
                null,
                'BE',
            ],
        ];

        if ($allowThreeDigitFieldFour) {
            $parts['field4'][] = '100';
            $parts['field4'][] = '001';
        }

        if ($allowLegacyIdentifier) {
            $parts['field3'][] = '1234A';
        }

        $virins = [];

        foreach (cartesian_product($parts) as $part) {
            // Only add field5 if field4 is 4 digits long
            if ($part['field5'] !== null && strlen($part['field4']) > 3) {
                $virins[] = [sprintf('%s-%s-%s-%s-%s', $part['field1'], $part['field2'], $part['field3'], $part['field4'], $part['field5']), true];
            } else {
                $virins[] = [sprintf('%s-%s-%s-%s', $part['field1'], $part['field2'], $part['field3'], $part['field4']), true];
            }
        }

        return $virins;
    }

    protected static function getInvalidVirinsForValidation(bool $allowThreeDigitFieldFour = false, bool $allowLegacyIdentifier = false): array
    {
        $parts = [
            'field1' => [
                '18051',
            ],
            'field2' => [
                'C',
            ],
            'field3' => [
                'A987',
                '0987'
            ],
            'field4' => [
                '10',
                '10011',
                '0001',
                '11a',
            ],
        ];

        if (!$allowThreeDigitFieldFour) {
            $parts['field4'][] = '100';
            $parts['field4'][] = '001';
        }

        if (!$allowLegacyIdentifier) {
            $parts['field3'][] = '1234A';
        }

        $virins = [];

        foreach (cartesian_product($parts) as $part) {
            $virins[] = [sprintf('%s-%s-%s-%s', $part['field1'], $part['field2'], $part['field3'], $part['field4']), false];
        }

        return $virins;
    }
}