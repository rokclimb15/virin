<?php

declare(strict_types=1);

namespace Rokclimb15\Virin\Test\Validator;

use Rokclimb15\Virin\Validator;
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
        return [
            [
                'value' => '180515-A-AA987-100',
                'expected' => true,
            ],
            [
                'value' => '180515-A-A0987-100',
                'expected' => true,
            ],
            [
                'value' => '180515-A-AA987-1001',
                'expected' => true,
            ],
            [
                'value' => '180515-A-A0987-1001',
                'expected' => true,
            ],
            [
                'value' => '180515-A-AA987-100-BE',
                'expected' => true,
            ],
            [
                'value' => '180515-A-A0987-100-BE',
                'expected' => true,
            ],
            [
                'value' => '180515-A-AA987-1001-BE',
                'expected' => true,
            ],
            [
                'value' => '180515-A-A0987-1001-BE',
                'expected' => true,
            ],
            [
                'value' => '180515-D-AA987-1001-BE',
                'expected' => true,
            ],
            [
                'value' => '180515-D-A0987-1001-BE',
                'expected' => true,
            ],
            [
                'value' => '180515-F-AA987-1001-BE',
                'expected' => true,
            ],
            [
                'value' => '180515-F-A0987-1001-BE',
                'expected' => true,
            ],
            [
                'value' => '180515-G-AA987-1001-BE',
                'expected' => true,
            ],
            [
                'value' => '180515-G-A0987-1001-BE',
                'expected' => true,
            ],
            [
                'value' => '180515-H-AA987-1001-BE',
                'expected' => true,
            ],
            [
                'value' => '180515-H-A0987-1001-BE',
                'expected' => true,
            ],
            [
                'value' => '180515-M-AA987-1001-BE',
                'expected' => true,
            ],
            [
                'value' => '180515-M-A0987-1001-BE',
                'expected' => true,
            ],
            [
                'value' => '180515-N-AA987-1001-BE',
                'expected' => true,
            ],
            [
                'value' => '180515-N-A0987-1001-BE',
                'expected' => true,
            ],
            [
                'value' => '180515-O-AA987-1001-BE',
                'expected' => true,
            ],
            [
                'value' => '180515-O-A0987-1001-BE',
                'expected' => true,
            ],
            [
                'value' => '180515-S-AA987-1001-BE',
                'expected' => true,
            ],
            [
                'value' => '180515-S-A0987-1001-BE',
                'expected' => true,
            ],
            [
                'value' => '180515-Z-AA987-1001-BE',
                'expected' => true,
            ],
            [
                'value' => '180515-Z-A0987-1001-BE',
                'expected' => true,
            ],
            [
                'value' => '18051-A-AA987-100',
                'expected' => false,
            ],
            [
                'value' => '18051-A-A0987-100',
                'expected' => false,
            ],
            [
                'value' => '180515-C-AA987-100',
                'expected' => false,
            ],
            [
                'value' => '180515-C-A0987-100',
                'expected' => false,
            ],
            [
                'value' => '180515-A-A987-100',
                'expected' => false,
            ],
            [
                'value' => '180515-A-A987-1001',
                'expected' => false,
            ],
            [
                'value' => '180515-A-A987-1001-BE',
                'expected' => false,
            ],
            [
                'value' => '180515-A-AA987A1234-1001-BE',
                'expected' => false,
            ],
        ];
    }
}