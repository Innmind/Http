<?php
declare(strict_types = 1);

namespace Tests\Innmind\Http\Header\ContentType;

use Innmind\Http\{
    Header\ContentType\Boundary,
    Header\Parameter,
    Exception\DomainException,
};
use PHPUnit\Framework\TestCase;
use Innmind\BlackBox\{
    PHPUnit\BlackBox,
    Set,
};

class BoundaryTest extends TestCase
{
    use BlackBox;

    public function testInterface()
    {
        $this->assertInstanceOf(Parameter::class, Boundary::uuid());
    }

    public function testOf()
    {
        $id = \uniqid();
        $boundary = Boundary::of($id);

        $this->assertSame($id, $boundary->value());
        $this->assertSame("boundary=\"$id\"", $boundary->toString());
    }

    public function testThrowWhenRandomString()
    {
        $this
            ->forAll(Set\Unicode::strings()->filter(
                static fn($string) => !\preg_match('~^[a-zA-Z0-9 \'()+_,-./:=?]{1,70}$~', $string),
            ))
            ->then(function($random) {
                try {
                    Boundary::of($random);
                    $this->fail('it should throw');
                } catch (DomainException $e) {
                    $this->assertSame($random, $e->getMessage());
                }
            });
    }
}
