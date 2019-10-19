<?php
declare(strict_types = 1);

namespace Tests\Innmind\Http\Message\StatusCode;

use Innmind\Http\Message\{
    StatusCode\StatusCode,
    StatusCode as StatusCodeInterface,
    ReasonPhrase
};
use Innmind\Immutable\MapInterface;
use PHPUnit\Framework\TestCase;

class StatusCodeTest extends TestCase
{
    public function testInterface()
    {
        $c = new StatusCode(200);

        $this->assertInstanceOf(StatusCodeInterface::class, $c);
        $this->assertSame(200, $c->value());
        $this->assertSame('200', (string) $c);
    }

    /**
     * @expectedException Innmind\Http\Exception\DomainException
     */
    public function testThrowWhenInvalidStatusCode()
    {
        new StatusCode(42); //sadly
    }

    public function testAssociatedReasonPhrase()
    {
        StatusCode::codes()->foreach(function($name, $code): void {
            $reason = StatusCode::of($name)->associatedReasonPhrase();

            $this->assertInstanceOf(ReasonPhrase::class, $reason);
            $this->assertSame(
                (string) ReasonPhrase\ReasonPhrase::defaults()->get($code),
                (string) $reason
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

        $this->assertInstanceOf(MapInterface::class, $codes);
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
            $this->assertTrue(StatusCode::isInformational(new StatusCode($code)));
        });

        $codes->get(false)->foreach(function($name, $code): void {
            $this->assertFalse(StatusCode::isInformational(new StatusCode($code)));
        });
    }

    public function testIsSuccessful()
    {
        $codes =  StatusCode::codes()->partition(static function($name, $code): bool {
            return ((int) ($code / 100)) === 2;
        });

        $codes->get(true)->foreach(function($name, $code): void {
            $this->assertTrue(StatusCode::isSuccessful(new StatusCode($code)));
        });

        $codes->get(false)->foreach(function($name, $code): void {
            $this->assertFalse(StatusCode::isSuccessful(new StatusCode($code)));
        });
    }

    public function testIsRedirection()
    {
        $codes =  StatusCode::codes()->partition(static function($name, $code): bool {
            return ((int) ($code / 100)) === 3;
        });

        $codes->get(true)->foreach(function($name, $code): void {
            $this->assertTrue(StatusCode::isRedirection(new StatusCode($code)));
        });

        $codes->get(false)->foreach(function($name, $code): void {
            $this->assertFalse(StatusCode::isRedirection(new StatusCode($code)));
        });
    }

    public function testIsClientError()
    {
        $codes =  StatusCode::codes()->partition(static function($name, $code): bool {
            return ((int) ($code / 100)) === 4;
        });

        $codes->get(true)->foreach(function($name, $code): void {
            $this->assertTrue(StatusCode::isClientError(new StatusCode($code)));
        });

        $codes->get(false)->foreach(function($name, $code): void {
            $this->assertFalse(StatusCode::isClientError(new StatusCode($code)));
        });
    }

    public function testIsServerError()
    {
        $codes =  StatusCode::codes()->partition(static function($name, $code): bool {
            return ((int) ($code / 100)) === 5;
        });

        $codes->get(true)->foreach(function($name, $code): void {
            $this->assertTrue(StatusCode::isServerError(new StatusCode($code)));
        });

        $codes->get(false)->foreach(function($name, $code): void {
            $this->assertFalse(StatusCode::isServerError(new StatusCode($code)));
        });
    }
}
