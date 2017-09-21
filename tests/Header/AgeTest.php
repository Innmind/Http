<?php
declare(strict_types = 1);

namespace Tests\Innmind\Http\Header;

use Innmind\Http\{
    Header\Age,
    Header,
    Header\HeaderValue,
    Header\AgeValue
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

        $this->assertInstanceOf(Header::class, $h);
        $this->assertSame('Age', $h->name());
        $v = $h->values();
        $this->assertInstanceOf(SetInterface::class, $v);
        $this->assertSame(HeaderValue::class, (string) $v->type());
        $this->assertSame($av, $v->current());
        $this->assertSame('Age : 42', (string) $h);
    }
}
