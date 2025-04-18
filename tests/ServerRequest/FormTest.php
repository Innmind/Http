<?php
declare(strict_types = 1);

namespace Tests\Innmind\Http\ServerRequest;

use Innmind\Http\ServerRequest\Form;
use Innmind\BlackBox\PHPUnit\Framework\TestCase;

class FormTest extends TestCase
{
    public function testInterface()
    {
        $form = Form::of([
            42 => '24',
            'foo' => 'bar',
        ]);

        $this->assertFalse($form->contains('24'));
        $this->assertTrue($form->contains(42));
        $this->assertSame('24', $form->get(42)->match(
            static fn($value) => $value,
            static fn() => null,
        ));
        $this->assertSame(2, $form->count());
        $this->assertSame(
            [
                42 => '24',
                'foo' => 'bar',
            ],
            $form->data(),
        );
    }

    public function testReturnNothingWhenAccessingUnknownParameter()
    {
        $this->assertNull(Form::of([])->get('foo')->match(
            static fn($foo) => $foo,
            static fn() => null,
        ));
    }

    public function testList()
    {
        $this->assertSame(
            [1, 2, 3],
            Form::of(['foo' => [1, 2, 3]])->list('foo')->match(
                static fn($list) => $list->data(),
                static fn() => null,
            ),
        );
        $this->assertNull(
            Form::of(['foo' => 'bar'])->list('foo')->match(
                static fn($list) => $list,
                static fn() => null,
            ),
        );
        $this->assertNull(
            Form::of(['foo' => [0 => 1, 2 => 3]])->list('foo')->match(
                static fn($list) => $list,
                static fn() => null,
            ),
        );
    }

    public function testDictionary()
    {
        $this->assertNull(
            Form::of(['foo' => [1, 2, 3]])->dictionary('foo')->match(
                static fn($list) => $list,
                static fn() => null,
            ),
        );
        $this->assertNull(
            Form::of(['foo' => 'bar'])->dictionary('foo')->match(
                static fn($list) => $list,
                static fn() => null,
            ),
        );
        $this->assertSame(
            [0 => 1, 2 => 3],
            Form::of(['foo' => [0 => 1, 2 => 3]])->dictionary('foo')->match(
                static fn($list) => $list->data(),
                static fn() => null,
            ),
        );
    }

    public function testNestedGet()
    {
        $form = Form::of([
            'foo' => [
                'bar' => [
                    'baz' => '42',
                ],
            ],
        ]);

        $this->assertSame(
            '42',
            $form
                ->dictionary('foo')
                ->flatMap(static fn($foo) => $foo->dictionary('bar'))
                ->flatMap(static fn($bar) => $bar->get('baz'))
                ->match(
                    static fn($baz) => $baz,
                    static fn() => null,
                ),
        );
    }
}
