<?php
declare(strict_types = 1);

namespace Tests\Innmind\Http\Header\Parameter;

use Innmind\Http\Header\Parameter\Quality;
use Innmind\BlackBox\PHPUnit\Framework\TestCase;

class QualityTest extends TestCase
{
    public function testInterface()
    {
        $p = Quality::of(80);

        $this->assertSame('q', $p->toParameter()->name());
        $this->assertSame('0.8', $p->toParameter()->value());
        $this->assertSame('q=0.8', $p->toParameter()->toString());

        $this->assertSame('q=0', Quality::of(0)->toParameter()->toString());
    }
}
