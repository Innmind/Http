<?php
declare(strict_types = 1);

namespace Innmind\Http\Tests\Header;

use Innmind\Http\Header\{
    Authorization,
    HeaderInterface,
    HeaderValueInterface,
    HeaderValue,
    AuthorizationValue
};
use Innmind\Immutable\Set;

class AuthorizationTest extends \PHPUnit_Framework_TestCase
{
    public function testInterface()
    {
        $h = new Authorization(
            $v = (new Set(HeaderValueInterface::class))
                ->add(new AuthorizationValue('Basic'))
        );

        $this->assertInstanceOf(HeaderInterface::class, $h);
        $this->assertSame('Authorization', $h->name());
        $this->assertSame($v, $h->values());
        $this->assertSame('Authorization : Basic', (string) $h);
    }

    /**
     * @expectedException Innmind\Http\Exception\InvalidArgumentException
     */
    public function testRangeThrowWhenBuildingWithoutAuthorizationValue()
    {
        new Authorization(
            (new Set(HeaderValueInterface::class))
                ->add(new HeaderValue('foo'))
        );
    }

    /**
     * @expectedException Innmind\Http\Exception\AuthorizationMustContainOnlyOneValueException
     */
    public function testThrowIfNoValueGiven()
    {
        new Authorization(new Set(HeaderValueInterface::class));
    }

    /**
     * @expectedException Innmind\Http\Exception\AuthorizationMustContainOnlyOneValueException
     */
    public function testThrowIfTooManyValuesGiven()
    {
        new Authorization(
            (new Set(HeaderValueInterface::class))
                ->add(new AuthorizationValue('Basic'))
                ->add(new AuthorizationValue('Digest'))
        );
    }
}
