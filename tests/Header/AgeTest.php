<?php
declare(strict_types = 1);

namespace Tests\Innmind\Http\Header;

use Innmind\Http\Header\{
    Age,
    HeaderInterface,
    HeaderValueInterface,
    AgeValue
};
use Innmind\Immutable\SetInterface;
use PHPUnit\Framework\TestCase;

class AgeTest extends TestCase
{
    public function testInterface()
    {
        $h = new Age(
            $av = new AgeValue(42)
        );

        $this->assertInstanceOf(HeaderInterface::class, $h);
        $this->assertSame('Age', $h->name());
        $v = $h->values();
        $this->assertInstanceOf(SetInterface::class, $v);
        $this->assertSame(HeaderValueInterface::class, (string) $v->type());
        $this->assertSame($av, $v->current());
        $this->assertSame('Age : 42', (string) $h);
    }
}
