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
        $this->assertSame('q=foo', $p->toString());

        $this->assertSame('level', (new Parameter('level', ''))->toString());
    }

    public function testQuoteWhenThereIsAWithespace()
    {
        $this->assertSame(
            'foo="bar baz"',
            (new Parameter('foo', 'bar baz'))->toString(),
        );
    }

    public function testQuoteWhenThereIsATab()
    {
        $this->assertSame(
            "foo=\"bar\tbaz\"",
            (new Parameter('foo', "bar\tbaz"))->toString(),
        );
    }

    public function testDoesntDuplicateQuotes()
    {
        $this->assertSame(
            'foo="bar baz"',
            (new Parameter('foo', '"bar baz"'))->toString(),
        );
    }

    public function testDoesntChangeIfAlreadyQuotedEvenIfNotNeeded()
    {
        $this->assertSame(
            'foo="bar"',
            (new Parameter('foo', '"bar"'))->toString(),
        );
    }
}
