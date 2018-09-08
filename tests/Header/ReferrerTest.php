<?php
declare(strict_types = 1);

namespace Tests\Innmind\Http\Header;

use Innmind\Http\{
    Header\Referrer,
    Header,
    Header\Value,
    Header\ReferrerValue
};
use Innmind\Immutable\SetInterface;
use Innmind\Url\Url;
use PHPUnit\Framework\TestCase;

class ReferrerTest extends TestCase
{
    public function testInterface()
    {
        $h = new Referrer(
            $av = new ReferrerValue(Url::fromString('/foo/bar'))
        );

        $this->assertInstanceOf(Header::class, $h);
        $this->assertSame('Referer', $h->name());
        $v = $h->values();
        $this->assertInstanceOf(SetInterface::class, $v);
        $this->assertSame(Value::class, (string) $v->type());
        $this->assertSame($av, $v->current());
        $this->assertSame('Referer: /foo/bar', (string) $h);
    }
}
