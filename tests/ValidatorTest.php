<?php

declare(strict_types=1);

namespace Rokclimb15\Virin\Test\Validator;

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

    public function valuesForValidation(): array
    {
        return array_merge($this->getValidVirinsForValidation(), $this->getInvalidVirinsForValidation());
    }

    protected function getValidVirinsForValidation(): array
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
                'Z',
            ],
            'field3' => [
                'AA987',
                'A0987'
            ],
            'field4' => [
                '100',
                '1001',
            ],
            'field5' => [
                null,
                'BE',
            ],
        ];

        $virins = [];

        foreach (cartesian_product($parts) as $part) {
            if ($part['field5'] !== null) {
                $virins[] = [sprintf('%s-%s-%s-%s-%s', $part['field1'], $part['field2'], $part['field3'], $part['field4'], $part['field5']), true];
            } else {
                $virins[] = [sprintf('%s-%s-%s-%s', $part['field1'], $part['field2'], $part['field3'], $part['field4']), true];
            }
        }

        return $virins;
    }

    protected function getInvalidVirinsForValidation(): array
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
            ],
        ];

        $virins = [];

        foreach (cartesian_product($parts) as $part) {
            $virins[] = [sprintf('%s-%s-%s-%s', $part['field1'], $part['field2'], $part['field3'], $part['field4']), false];
        }

        return $virins;
    }
}