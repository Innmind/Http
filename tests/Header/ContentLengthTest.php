<?php
declare(strict_types = 1);

namespace Tests\Innmind\Http\Header;

use Innmind\Http\{
    Header\ContentLength,
    Header,
};
use Innmind\BlackBox\PHPUnit\Framework\TestCase;

class ContentLengthTest extends TestCase
{
    public function testOf()
    {
        $header = ContentLength::of(42);

        $this->assertInstanceOf(ContentLength::class, $header);
        $this->assertInstanceOf(Header\Custom::class, $header);
        $this->assertSame('Content-Length: 42', $header->normalize()->toString());
    }

    public function testReturnNothingWhenInvalidContentLengthValue()
    {
        $this->assertNull(ContentLength::maybe(-1)->match(
            static fn($header) => $header,
            static fn() => null,
        ));
    }
}
