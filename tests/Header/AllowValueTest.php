<?php
declare(strict_types = 1);

namespace Tests\Innmind\Http\Header;

use Innmind\Http\Header\{
    AllowValue,
    Value,
};
use PHPUnit\Framework\TestCase;

class AllowValueTest extends TestCase
{
    public function testInterface()
    {
        $a = new AllowValue('HEAD');

        $this->assertInstanceOf(Value::class, $a);
        $this->assertSame('HEAD', $a->toString());

        new AllowValue('GET');
        new AllowValue('POST');
        new AllowValue('PUT');
        new AllowValue('DELETE');
        new AllowValue('TRACE');
        new AllowValue('CONNECT');
        new AllowValue('OPTIONS');
        new AllowValue('PATCH');
    }

    /**
     * @dataProvider invalids
     */
    public function testThrowWhenInvalidAllowValue($value)
    {
        $this->expectException(\UnhandledMatchError::class);

        new AllowValue($value);
    }

    public static function invalids(): array
    {
        return [
            ['42'],
            ['get'],
            ['FOO'],
        ];
    }
}
