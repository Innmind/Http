<?php
declare(strict_types = 1);

namespace Tests\Innmind\Http\Message;

use Innmind\Http\{
    Message\StatusCode,
    Message\ReasonPhrase,
    Exception\DomainException,
};
use Innmind\Immutable\Map;
use function Innmind\Immutable\unwrap;
use PHPUnit\Framework\TestCase;
use Innmind\BlackBox\{
    PHPUnit\BlackBox,
    Set,
};

class StatusCodeTest extends TestCase
{
    use BlackBox;

    public function testInterface()
    {
        $c = new StatusCode(200);

        $this->assertSame(200, $c->value());
        $this->assertSame('200', $c->toString());
    }

    public function testThrowWhenInvalidStatusCode()
    {
        $this->expectException(DomainException::class);
        $this->expectExceptionMessage('42');

        new StatusCode(42); //sadly
    }

    public function testAssociatedReasonPhrase()
    {
        StatusCode::codes()->foreach(function($name, $code): void {
            $reason = StatusCode::of($name)->associatedReasonPhrase();

            $this->assertInstanceOf(ReasonPhrase::class, $reason);
            $this->assertSame(
                ReasonPhrase::defaults()->get($code),
                $reason->toString()
            );
        });
    }

    public function testOf()
    {
        StatusCode::codes()->foreach(function($name, $code): void {
            $status = StatusCode::of($name);

            $this->assertInstanceOf(StatusCode::class, $status);
            $this->assertSame($code, $status->value());
        });
    }

    public function testCodes()
    {
        $codes = StatusCode::codes();

        $this->assertInstanceOf(Map::class, $codes);
        $this->assertSame('string', (string) $codes->keyType());
        $this->assertSame('int', (string) $codes->valueType());
        $this->assertSame(74, $codes->count());
    }

    public function testIsInformational()
    {
        $codes =  StatusCode::codes()->partition(static function($name, $code): bool {
            return ((int) ($code / 100)) === 1;
        });

        $codes->get(true)->foreach(function($name, $code): void {
            $this->assertTrue((new StatusCode($code))->isInformational());
        });

        $codes->get(false)->foreach(function($name, $code): void {
            $this->assertFalse((new StatusCode($code))->isInformational());
        });
    }

    public function testIsSuccessful()
    {
        $codes =  StatusCode::codes()->partition(static function($name, $code): bool {
            return ((int) ($code / 100)) === 2;
        });

        $codes->get(true)->foreach(function($name, $code): void {
            $this->assertTrue((new StatusCode($code))->isSuccessful());
        });

        $codes->get(false)->foreach(function($name, $code): void {
            $this->assertFalse((new StatusCode($code))->isSuccessful());
        });
    }

    public function testIsRedirection()
    {
        $codes =  StatusCode::codes()->partition(static function($name, $code): bool {
            return ((int) ($code / 100)) === 3;
        });

        $codes->get(true)->foreach(function($name, $code): void {
            $this->assertTrue((new StatusCode($code))->isRedirection());
        });

        $codes->get(false)->foreach(function($name, $code): void {
            $this->assertFalse((new StatusCode($code))->isRedirection());
        });
    }

    public function testIsClientError()
    {
        $codes =  StatusCode::codes()->partition(static function($name, $code): bool {
            return ((int) ($code / 100)) === 4;
        });

        $codes->get(true)->foreach(function($name, $code): void {
            $this->assertTrue((new StatusCode($code))->isClientError());
        });

        $codes->get(false)->foreach(function($name, $code): void {
            $this->assertFalse((new StatusCode($code))->isClientError());
        });
    }

    public function testIsServerError()
    {
        $codes =  StatusCode::codes()->partition(static function($name, $code): bool {
            return ((int) ($code / 100)) === 5;
        });

        $codes->get(true)->foreach(function($name, $code): void {
            $this->assertTrue((new StatusCode($code))->isServerError());
        });

        $codes->get(false)->foreach(function($name, $code): void {
            $this->assertFalse((new StatusCode($code))->isServerError());
        });
    }

    public function testEquality()
    {
        $this
            ->forAll(Set\Elements::of(...unwrap(StatusCode::codes()->keys())))
            ->then(function($code) {
                $status = StatusCode::of($code);

                $this->assertTrue($status->equals($status));
                $this->assertTrue($status->equals(StatusCode::of($code)));
            });
    }

    public function testInequality()
    {
        $this
            ->forAll(
                Set\Elements::of(...unwrap(StatusCode::codes()->keys())),
                Set\Elements::of(...unwrap(StatusCode::codes()->keys())),
            )
            ->filter(fn($a, $b) => $a !== $b)
            ->then(function($a, $b) {
                $this->assertFalse(StatusCode::of($a)->equals(StatusCode::of($b)));
            });
    }
}
