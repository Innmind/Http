<?php
declare(strict_types = 1);

namespace Tests\Innmind\Http\Header;

use Innmind\Http\{
    Header\ContentLanguage,
    Header,
    Header\Value,
    Header\ContentLanguageValue
};
use Innmind\Immutable\Set;
use PHPUnit\Framework\TestCase;

class ContentLanguageTest extends TestCase
{
    public function testInterface()
    {
        $h = new ContentLanguage(
            $v = (new Set(Value::class))
                ->add(new ContentLanguageValue('fr'))
        );

        $this->assertInstanceOf(Header::class, $h);
        $this->assertSame('Content-Language', $h->name());
        $this->assertSame($v, $h->values());
        $this->assertSame('Content-Language : fr', (string) $h);
    }

    public function testWithoutValues()
    {
        $this->assertSame('Content-Language : ', (string) new ContentLanguage);
    }

    /**
     * @expectedException Innmind\Http\Exception\InvalidArgumentException
     */
    public function testThrowWhenBuildingWithoutContentLanguageValues()
    {
        new ContentLanguage(
            (new Set(Value::class))
                ->add(new Value\Value('foo'))
        );
    }
}
