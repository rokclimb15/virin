<?php

declare(strict_types=1);

namespace Rokclimb15\Virin\Test;

use Rokclimb15\Virin\Parser;
use Rokclimb15\Virin\Parser\Exception;
use function BenTools\CartesianProduct\cartesian_product;
use PHPUnit\Framework\TestCase as PhpUnitTestCase;

class ParserTest extends PhpUnitTestCase
{
    /**
     * @dataProvider valuesForParsing
     * @param string $value
     * @param array $expected
     * @throws Exception
     */
    public function testParse(string $value, array $expected): void
    {
        $parser = new Parser();

        $this->assertSame($expected, $parser->parse($value));

        $datetime = \DateTime::createFromFormat('!ymd', '180515');

        $this->assertEquals($datetime, $parser->getDateTime());
        $this->assertSame($expected[1], $parser->getBranchCode());
        $this->assertSame($expected[2], $parser->getVisionIdOrDvian());
        $this->assertSame($expected[3], $parser->getSequence());

        $field5 = $expected[4] ?? null;
        $this->assertSame($field5, $parser->getIso2CountryCode());

        $hasVisionId = ctype_alpha(substr($expected[2], 0, 2));

        $expectThreeDigitSequence = strlen($expected[3]) === 3;
        $this->assertSame($expectThreeDigitSequence, $parser->hasThreeDigitSequence());

        $this->assertSame(!$hasVisionId, $parser->hasDvian());
        $this->assertSame($hasVisionId, $parser->hasVisionId());
    }

    public function testParseThrowsExceptionWithBadFormat(): void
    {
        $parser = new Parser();

        $this->expectException(Exception::class);

        $parser->parse('1802011-A-AB123-100');
    }

    public function testParseThrowsExceptionWithBadDateString(): void
    {
        $parser = new Parser();

        $this->expectException(Exception::class);

        $parser->parse('180299-A-AB123-100');
        $parser->getDateTime();
    }

    public static function valuesForParsing(): array
    {
        return static::getValidVirinsForParsing();
    }

    protected static function getValidVirinsForParsing(): array
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
                'U',
                'X',
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
                $virins[] = [
                    sprintf('%s-%s-%s-%s-%s', $part['field1'], $part['field2'], $part['field3'], $part['field4'], $part['field5']),
                    [$part['field1'], $part['field2'], $part['field3'], $part['field4'], $part['field5']],
                ];
            } else {
                $virins[] = [
                    sprintf('%s-%s-%s-%s', $part['field1'], $part['field2'], $part['field3'], $part['field4']),
                    [$part['field1'], $part['field2'], $part['field3'], $part['field4']],
                ];
            }
        }

        return $virins;
    }
}