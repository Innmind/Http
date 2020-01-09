<?php
declare(strict_types = 1);

namespace Tests\Innmind\Http\Header;

use Innmind\Http\{
    Header\Accept,
    Header,
    Header\AcceptValue,
    Header\Parameter\Quality,
    Header\Parameter
};
use Innmind\Immutable\{
    Set,
    Map
};
use PHPUnit\Framework\TestCase;

class AcceptTest extends TestCase
{
    public function testInterface()
    {
        $h = new Accept(
            $v = new AcceptValue(
                'text',
                'html',
                new Quality(0.8),
            )
        );

        $this->assertInstanceOf(Header::class, $h);
        $this->assertSame('Accept', $h->name());
        $this->assertTrue($h->values()->contains($v));
        $this->assertSame('Accept: text/html;q=0.8', (string) $h);
    }
}
