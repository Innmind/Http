<?php
declare(strict_types = 1);

namespace Tests\Innmind\Http\Factory\Form;

use Innmind\Http\{
    Factory\Form\FormFactory,
    Factory\FormFactory as FormFactoryInterface,
    Message\Form
};
use PHPUnit\Framework\TestCase;

class FormFactoryTest extends TestCase
{
    public function testMake()
    {
        $f = new FormFactory;

        $this->assertInstanceOf(FormFactoryInterface::class, $f);

        $_POST = [
            'tree' => [
                'subtree' => [
                    'some' => 'value',
                ],
            ],
            'another' => 'value',
        ];
        $f = ($f)();

        $this->assertInstanceOf(Form::class, $f);
        $this->assertSame(2, $f->count());
        $this->assertSame(
            [
                'subtree' => [
                    'some' => 'value',
                ],
            ],
            $f->get('tree')->match(
                static fn($tree) => $tree->value(),
                static fn() => null,
            ),
        );
        $this->assertSame('value', $f->get('another')->match(
            static fn($another) => $another->value(),
            static fn() => null,
        ));
    }
}
