<?php
declare(strict_types = 1);

namespace Tests\Innmind\Http\Header;

use Innmind\Http\{
    Header,
    Header\Value
};
use Innmind\Immutable\Set;
use PHPUnit\Framework\TestCase;

class HeaderTest extends TestCase
{
    public function testInterface()
    {
        $h = new Header\Header(
            'Accept',
            $v1 = new Value\Value('application/json'),
            $v2 = new Value\Value('*/*')
        );

        $this->assertInstanceOf(Header::class, $h);
        $this->assertSame('Accept', $h->name());
        $this->assertTrue($h->values()->contains($v1));
        $this->assertTrue($h->values()->contains($v2));
        $this->assertSame('Accept: application/json, */*', $h->toString());
    }

    public function testWithoutValues()
    {
        $this->assertSame('X-Foo: ', (new Header\Header('X-Foo'))->toString());
    }
}
