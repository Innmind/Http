<?php
declare(strict_types = 1);

namespace Tests\Innmind\Http\Message;

use Innmind\Http\{
    Message\ReasonPhrase,
    Exception\DomainException,
};
use Innmind\Immutable\Map;
use PHPUnit\Framework\TestCase;

class ReasonPhraseTest extends TestCase
{
    public function testInterface()
    {
        $m = new ReasonPhrase('OK');

        $this->assertSame('OK', $m->toString());
    }

    public function testThrowWhenInvalidReasonPhrase()
    {
        $this->expectException(DomainException::class);

        new ReasonPhrase('');
    }

    public function testOf()
    {
        ReasonPhrase::defaults()->foreach(function($statusCode, $message): void {
            $reason = ReasonPhrase::of($statusCode);

            $this->assertInstanceOf(ReasonPhrase::class, $reason);
            $this->assertSame($message, $reason->toString());
        });
    }

    public function testDefaults()
    {
        $defaults = ReasonPhrase::defaults();

        $this->assertInstanceOf(Map::class, $defaults);
        $this->assertSame(74, $defaults->count());
    }
}
