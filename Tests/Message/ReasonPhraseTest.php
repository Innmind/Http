<?php
declare(strict_types = 1);

namespace Innmind\Http\Tests\Message;

use Innmind\Http\Message\{
    ReasonPhrase,
    ReasonPhraseInterface
};

class ReasonPhraseTest extends \PHPUnit_Framework_TestCase
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
}
