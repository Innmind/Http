<?php
declare(strict_types = 1);

namespace Tests\Innmind\Http\Header;

use Innmind\Http\{
    Header\Accept\MediaType,
    Header\Parameter\Quality,
    Header\Parameter,
};
use Innmind\BlackBox\PHPUnit\Framework\TestCase;
use PHPUnit\Framework\Attributes\DataProvider;

class AcceptValueTest extends TestCase
{
    public function testInterface()
    {
        $a = MediaType::maybe(
            'text',
            'x-c',
            $q = new Quality(0.8),
        )->match(
            static fn($mediaType) => $mediaType,
            static fn() => null,
        );

        $this->assertInstanceOf(MediaType::class, $a);
        $this->assertSame('text', $a->type());
        $this->assertSame('x-c', $a->subType());
        $this->assertSame($q, $a->parameters()->get('q')->match(
            static fn($q) => $q,
            static fn() => null,
        ));
        $this->assertSame('text/x-c;q=0.8', $a->toString());

        MediaType::maybe(
            '*',
            '*',
        )->match(
            static fn($mediaType) => $mediaType,
            static fn() => throw new \Exception,
        );
        MediaType::maybe(
            'application',
            '*',
        )->match(
            static fn($mediaType) => $mediaType,
            static fn() => throw new \Exception,
        );
        MediaType::maybe(
            'application',
            'octet-stream',
        )->match(
            static fn($mediaType) => $mediaType,
            static fn() => throw new \Exception,
        );
        MediaType::maybe(
            'application',
            'octet-stream',
            new Quality(0.4),
            new Parameter\Parameter('level', '1'),
        )->match(
            static fn($mediaType) => $mediaType,
            static fn() => throw new \Exception,
        );
    }

    #[DataProvider('invalids')]
    public function testReturnNothingWhenInvalidAcceptValue($type, $sub)
    {
        $this->assertNull(MediaType::maybe($type, $sub)->match(
            static fn($mediaType) => $mediaType,
            static fn() => null,
        ));
    }

    public static function invalids(): array
    {
        return [
            ['*', 'octet-stream'],
            ['foo/bar', ''],
            ['foo', 'bar+suffix'],
            ['foo', 'bar, level=1'],
        ];
    }
}
