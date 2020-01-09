<?php
declare(strict_types = 1);

namespace Tests\Innmind\Http\Message;

use Innmind\Http\Message\{
    Form,
    Form\Parameter
};
use Innmind\Immutable\Map;
use PHPUnit\Framework\TestCase;

class FormTest extends TestCase
{
    public function testInterface()
    {
        $f = new Form(
            $p = new Parameter\Parameter(
                '42',
                24
            )
        );

        $this->assertFalse($f->contains(24));
        $this->assertTrue($f->contains('42'));
        $this->assertSame($p, $f->get('42'));
        $this->assertSame(1, $f->count());
        $this->assertSame($p, $f->current());
        $this->assertSame('42', $f->key());
        $this->assertTrue($f->valid());
        $this->assertSame(null, $f->next());
        $this->assertFalse($f->valid());
        $this->assertSame(null, $f->rewind());
        $this->assertTrue($f->valid());
        $this->assertSame($p, $f->current());
    }

    public function testOf()
    {
        $form = Form::of(new Parameter\Parameter('42', 24));

        $this->assertInstanceOf(Form::class, $form);
        $this->assertTrue($form->contains('42'));
    }

    /**
     * @expectedException Innmind\Http\Exception\FormParameterNotFound
     */
    public function testThrowWhenAccessingUnknownParameter()
    {
        (new Form)->get('foo');
    }
}
