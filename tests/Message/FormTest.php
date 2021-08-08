<?php
declare(strict_types = 1);

namespace Tests\Innmind\Http\Message;

use Innmind\Http\{
    Message\Form,
    Message\Form\Parameter,
};
use Innmind\Immutable\SideEffect;
use PHPUnit\Framework\TestCase;

class FormTest extends TestCase
{
    public function testInterface()
    {
        $f = new Form(
            $p = new Parameter(
                '42',
                '24'
            )
        );

        $this->assertFalse($f->contains('24'));
        $this->assertTrue($f->contains('42'));
        $this->assertSame($p, $f->get('42')->match(
            static fn($parameter) => $parameter,
            static fn() => null,
        ));
        $this->assertSame(1, $f->count());
    }

    public function testOf()
    {
        $form = Form::of(new Parameter('42', '24'));

        $this->assertInstanceOf(Form::class, $form);
        $this->assertTrue($form->contains('42'));
    }

    public function testReturnNothingWhenAccessingUnknownParameter()
    {
        $this->assertNull((new Form)->get('foo')->match(
            static fn($foo) => $foo,
            static fn() => null,
        ));
    }

    public function testForeach()
    {
        $form = new Form(
            new Parameter('foo', 'bar'),
            new Parameter('bar', 'baz'),
        );

        $called = 0;
        $this->assertInstanceOf(
            SideEffect::class,
            $form->foreach(static function() use (&$called) {
                ++$called;
            }),
        );
        $this->assertSame(2, $called);
    }

    public function testReduce()
    {
        $form = new Form(
            new Parameter('foo', 'bar'),
            new Parameter('bar', 'baz'),
        );

        $reduced = $form->reduce(
            [],
            static function($carry, $parameter) {
                $carry[] = $parameter->name();
                $carry[] = $parameter->value();

                return $carry;
            },
        );

        $this->assertSame(['foo', 'bar', 'bar', 'baz'], $reduced);
    }
}
