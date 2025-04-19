<?php
declare(strict_types = 1);

namespace Tests\Innmind\Http\Header;

use Innmind\Http\{
    Header\Age,
    Header,
    Header\AgeValue
};
use Innmind\Immutable\Sequence;
use Innmind\BlackBox\PHPUnit\Framework\TestCase;

class AgeTest extends TestCase
{
    public function testInterface()
    {
        $h = new Age(
            $av = new AgeValue(42),
        );

        $this->assertInstanceOf(Header::class, $h);
        $this->assertSame('Age', $h->name());
        $v = $h->values();
        $this->assertInstanceOf(Sequence::class, $v);
        $this->assertSame($av, $v->find(static fn() => true)->match(
            static fn($first) => $first,
            static fn() => null,
        ));
        $this->assertSame('Age: 42', $h->toString());
        $this->assertSame(42, $h->age());
    }

    public function testOf()
    {
        $header = Age::of(42);

        $this->assertInstanceOf(Age::class, $header);
        $this->assertSame('Age', $header->name());
        $values = $header->values();
        $this->assertInstanceOf(Sequence::class, $values);
        $this->assertSame('Age: 42', $header->toString());
    }
}
