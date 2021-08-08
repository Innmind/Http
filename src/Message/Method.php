<?php
declare(strict_types = 1);

namespace Innmind\Http\Message;

use Innmind\Http\Exception\DomainException;

/**
 * @psalm-immutable
 */
final class Method
{
    private const GET = 'GET';
    private const POST = 'POST';
    private const PUT = 'PUT';
    private const PATCH = 'PATCH';
    private const DELETE = 'DELETE';
    private const OPTIONS = 'OPTIONS';
    private const TRACE = 'TRACE';
    private const CONNECT = 'CONNECT';
    private const HEAD = 'HEAD';
    private const LINK = 'LINK';
    private const UNLINK = 'UNLINK';

    private string $method;

    public function __construct(string $method)
    {
        if (!\defined('self::'.$method)) {
            throw new DomainException($method);
        }

        $this->method = $method;
    }

    /**
     * @psalm-pure
     */
    public static function get(): self
    {
        return new self(self::GET);
    }

    /**
     * @psalm-pure
     */
    public static function post(): self
    {
        return new self(self::POST);
    }

    /**
     * @psalm-pure
     */
    public static function put(): self
    {
        return new self(self::PUT);
    }

    /**
     * @psalm-pure
     */
    public static function patch(): self
    {
        return new self(self::PATCH);
    }

    /**
     * @psalm-pure
     */
    public static function delete(): self
    {
        return new self(self::DELETE);
    }

    /**
     * @psalm-pure
     */
    public static function options(): self
    {
        return new self(self::OPTIONS);
    }

    /**
     * @psalm-pure
     */
    public static function trace(): self
    {
        return new self(self::TRACE);
    }

    /**
     * @psalm-pure
     */
    public static function connect(): self
    {
        return new self(self::CONNECT);
    }

    /**
     * @psalm-pure
     */
    public static function head(): self
    {
        return new self(self::HEAD);
    }

    /**
     * @psalm-pure
     */
    public static function link(): self
    {
        return new self(self::LINK);
    }

    /**
     * @psalm-pure
     */
    public static function unlink(): self
    {
        return new self(self::UNLINK);
    }

    public function equals(self $other): bool
    {
        return $this->toString() === $other->toString();
    }

    public function toString(): string
    {
        return $this->method;
    }
}
