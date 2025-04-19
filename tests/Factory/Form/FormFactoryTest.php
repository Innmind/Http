<?php
declare(strict_types = 1);

namespace Tests\Innmind\Http\Factory\Form;

use Innmind\Http\{
    Factory\FormFactory,
    ServerRequest\Form,
};
use Innmind\BlackBox\PHPUnit\Framework\TestCase;

class FormFactoryTest extends TestCase
{
    public function testMake()
    {
        $_POST = [
            'tree' => [
                'subtree' => [
                    'some' => 'value',
                ],
            ],
            'another' => 'value',
        ];
        $f = FormFactory::default();

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
                static fn($tree) => $tree,
                static fn() => null,
            ),
        );
        $this->assertSame('value', $f->get('another')->match(
            static fn($another) => $another,
            static fn() => null,
        ));
    }
}
