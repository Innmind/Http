<?php
declare(strict_types = 1);

namespace Tests\Innmind\Http\Header;

use Innmind\Http\{
    Header\Accept,
    Header,
    Header\AcceptValue,
    Header\Parameter\Quality
};
use Innmind\BlackBox\PHPUnit\Framework\TestCase;

class AcceptTest extends TestCase
{
    public function testInterface()
    {
        $h = new Accept(
            $v = new AcceptValue(
                'text',
                'html',
                new Quality(0.8),
            ),
        );

        $this->assertInstanceOf(Header\Provider::class, $h);
        $this->assertSame('Accept: text/html;q=0.8', $h->toHeader()->toString());
    }
}
