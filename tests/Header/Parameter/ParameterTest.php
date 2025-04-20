<?php
declare(strict_types = 1);

namespace Tests\Innmind\Http\Header\Parameter;

use Innmind\Http\Header\Parameter;
use Innmind\BlackBox\PHPUnit\Framework\TestCase;

class ParameterTest extends TestCase
{
    public function testInterface()
    {
        $p = Parameter::of('q', 'foo');

        $this->assertSame('q', $p->name());
        $this->assertSame('foo', $p->value());
        $this->assertSame('q=foo', $p->toString());

        $this->assertSame('level', (Parameter::of('level', ''))->toString());
    }

    public function testQuoteWhenThereIsAWithespace()
    {
        $this->assertSame(
            'foo="bar baz"',
            (Parameter::of('foo', 'bar baz'))->toString(),
        );
    }

    public function testQuoteWhenThereIsATab()
    {
        $this->assertSame(
            "foo=\"bar\tbaz\"",
            (Parameter::of('foo', "bar\tbaz"))->toString(),
        );
    }

    public function testDoesntDuplicateQuotes()
    {
        $this->assertSame(
            'foo="bar baz"',
            (Parameter::of('foo', '"bar baz"'))->toString(),
        );
    }

    public function testDoesntChangeIfAlreadyQuotedEvenIfNotNeeded()
    {
        $this->assertSame(
            'foo="bar"',
            (Parameter::of('foo', '"bar"'))->toString(),
        );
    }
}
