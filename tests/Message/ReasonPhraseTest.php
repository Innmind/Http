<?php
declare(strict_types = 1);

namespace Tests\Innmind\Http\Message;

use Innmind\Http\Message\{
    ReasonPhrase,
    ReasonPhraseInterface
};
use Innmind\Immutable\MapInterface;
use PHPUnit\Framework\TestCase;

class ReasonPhraseTest extends TestCase
{
    public function testInterface()
    {
        $m = new ReasonPhrase('OK');

        $this->assertInstanceOf(ReasonPhraseInterface::class, $m);
        $this->assertSame('OK', (string) $m);
    }

    /**
     * @expectedException Innmind\Http\Exception\InvalidArgumentException
     */
    public function testThrowWhenInvalidReasonPhrase()
    {
        new ReasonPhrase('');
    }

    public function testDefaults()
    {
        $defaults = ReasonPhrase::defaults();

        $this->assertInstanceOf(MapInterface::class, $defaults);
        $this->assertSame('int', (string) $defaults->keyType());
        $this->assertSame('string', (string) $defaults->valueType());
        $this->assertSame(60, $defaults->count());
    }
}
