<?php
declare(strict_types = 1);

namespace Tests\Innmind\Http\Header\Parameter;

use Innmind\Http\Header\{
    Parameter\Parameter,
    Parameter as ParameterInterface
};
use PHPUnit\Framework\TestCase;

class ParameterTest extends TestCase
{
    public function testInterface()
    {
        $p = new Parameter('q', 'foo');

        $this->assertInstanceOf(ParameterInterface::class, $p);
        $this->assertSame('q', $p->name());
        $this->assertSame('foo', $p->value());
        $this->assertSame('q=foo', (string) $p);

        $this->assertSame('level', (string) new Parameter('level', ''));
    }

    public function testQuoteWhenThereIsAWithespace()
    {
        $this->assertSame(
            'foo="bar baz"',
            (string) new Parameter('foo', 'bar baz')
        );
    }

    public function testQuoteWhenThereIsATab()
    {
        $this->assertSame(
            "foo=\"bar\tbaz\"",
            (string) new Parameter('foo', "bar\tbaz")
        );
    }

    public function testDoesntDuplicateQuotes()
    {
        $this->assertSame(
            'foo="bar baz"',
            (string) new Parameter('foo', '"bar baz"')
        );
    }

    public function testDoesntChangeIfAlreadyQuotedEvenIfNotNeeded()
    {
        $this->assertSame(
            'foo="bar"',
            (string) new Parameter('foo', '"bar"')
        );
    }
}