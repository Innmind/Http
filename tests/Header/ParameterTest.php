<?php
declare(strict_types = 1);

namespace Tests\Innmind\Http\Header;

use Innmind\Http\Header\{
    Parameter,
    ParameterInterface
};

class ParameterTest extends \PHPUnit_Framework_TestCase
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
