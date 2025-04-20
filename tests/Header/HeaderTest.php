<?php
declare(strict_types = 1);

namespace Tests\Innmind\Http\Header;

use Innmind\Http\{
    Header,
    Header\Value
};
use Innmind\BlackBox\PHPUnit\Framework\TestCase;

class HeaderTest extends TestCase
{
    public function testInterface()
    {
        $h = Header::of(
            'Accept',
            $v1 = Value::of('application/json'),
            $v2 = Value::of('*/*'),
        );

        $this->assertInstanceOf(Header::class, $h);
        $this->assertSame('Accept', $h->name());
        $this->assertTrue($h->values()->contains($v1));
        $this->assertTrue($h->values()->contains($v2));
        $this->assertSame('Accept: application/json, */*', $h->toString());
    }

    public function testWithoutValues()
    {
        $this->assertSame('X-Foo: ', Header::of('X-Foo')->toString());
    }
}
