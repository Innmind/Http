<?php
declare(strict_types = 1);

namespace Tests\Innmind\Http\Header;

use Innmind\Http\{
    Header\Accept,
    Header,
    Header\Parameter\Quality,
};
use Innmind\BlackBox\PHPUnit\Framework\TestCase;

class AcceptTest extends TestCase
{
    public function testInterface()
    {
        $h = Accept\MediaType::maybe(
            'text',
            'html',
            Quality::of(80)->toParameter(),
        )
            ->map(Accept::of(...))
            ->match(
                static fn($header) => $header,
                static fn() => null,
            );

        $this->assertInstanceOf(Header\Custom::class, $h);
        $this->assertSame('Accept: text/html;q=0.8', $h->normalize()->toString());
    }
}
