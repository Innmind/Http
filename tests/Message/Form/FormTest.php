<?php
declare(strict_types = 1);

namespace Tests\Innmind\Http\Message\Form;

use Innmind\Http\Message\{
    Form\Form,
    Form as FormInterface,
    Form\Parameter
};
use Innmind\Immutable\Map;
use PHPUnit\Framework\TestCase;

class FormTest extends TestCase
{
    public function testInterface()
    {
        $f = new Form(
            (new Map('scalar', Parameter::class))
                ->put(
                    42,
                    $p = new Parameter\Parameter(
                        '42',
                        24
                    )
                )
        );

        $this->assertInstanceOf(FormInterface::class, $f);
        $this->assertTrue($f->has(42));
        $this->assertFalse($f->has('42'));
        $this->assertSame($p, $f->get(42));
        $this->assertSame(1, $f->count());
        $this->assertSame($p, $f->current());
        $this->assertSame(42, $f->key());
        $this->assertTrue($f->valid());
        $this->assertSame(null, $f->next());
        $this->assertFalse($f->valid());
        $this->assertSame(null, $f->rewind());
        $this->assertTrue($f->valid());
        $this->assertSame($p, $f->current());
    }

    /**
     * @expectedException Innmind\Http\Exception\FormParameterNotFound
     */
    public function testThrowWhenAccessingUnknownParameter()
    {
        (new Form)->get('foo');
    }

    /**
     * @expectedException TypeError
     * @expectedExceptionMessage Argument 1 must be of type MapInterface<scalar, Innmind\Http\Message\Form\Parameter>
     */
    public function testThrowWhenInvalidMap()
    {
        new Form(new Map('string', 'string'));
    }
}
