<?php
declare(strict_types = 1);

namespace Innmind\Http\Tests\Header;

use Innmind\Http\Header\{
    Header,
    HeaderInterface,
    HeaderValueInterface,
    HeaderValue
};
use Innmind\Immutable\Set;

class HeaderTest extends \PHPUnit_Framework_TestCase
{
    public function testInterface()
    {
        $h = new Header(
            'Accept',
            $v = (new Set(HeaderValueInterface::class))
                ->add(new HeaderValue('application/json'))
                ->add(new HeaderValue('*/*'))
        );

        $this->assertInstanceOf(HeaderInterface::class, $h);
        $this->assertSame('Accept', $h->name());
        $this->assertSame($v, $h->values());
        $this->assertSame('Accept : application/json, */*', (string) $h);
    }

    /**
     * @expectedException Innmind\Http\Exception\InvalidArgumentException
     */
    public function testThrowWhenInvalidSetOfValues()
    {
        new Header('Accept', new Set('string'));
    }
}
