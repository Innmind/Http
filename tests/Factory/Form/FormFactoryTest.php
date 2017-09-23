<?php
declare(strict_types = 1);

namespace Tests\Innmind\Http\Factory\Form;

use Innmind\Http\{
    Factory\Form\FormFactory,
    Factory\FormFactory as FormFactoryInterface,
    Message\Form
};
use Innmind\Immutable\{
    Map,
    MapInterface
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
        $f = $f->make();

        $this->assertInstanceOf(Form::class, $f);
        $this->assertSame(2, $f->count());
        $this->assertInstanceOf(MapInterface::class, $f->get('tree')->value());
        $this->assertSame(
            'value',
            $f->get('tree')->value()->get('subtree')->value()->get('some')->value()
        );
        $this->assertSame('value', $f->get('another')->value());
    }
}
