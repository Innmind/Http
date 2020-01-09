<?php
declare(strict_types = 1);

namespace Innmind\Http\Message;

use Innmind\Http\Exception\DomainException;

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

    private $method;

    public function __construct(string $method)
    {
        if (!defined('self::'.$method)) {
            throw new DomainException;
        }

        $this->method = $method;
    }

    public static function get(): self
    {
        return new self(self::GET);
    }

    public static function post(): self
    {
        return new self(self::POST);
    }

    public static function put(): self
    {
        return new self(self::PUT);
    }

    public static function patch(): self
    {
        return new self(self::PATCH);
    }

    public static function delete(): self
    {
        return new self(self::DELETE);
    }

    public static function options(): self
    {
        return new self(self::OPTIONS);
    }

    public static function trace(): self
    {
        return new self(self::TRACE);
    }

    public static function connect(): self
    {
        return new self(self::CONNECT);
    }

    public static function head(): self
    {
        return new self(self::HEAD);
    }

    public static function link(): self
    {
        return new self(self::LINK);
    }

    public static function unlink(): self
    {
        return new self(self::UNLINK);
    }

    public function toString(): string
    {
        return $this->method;
    }
}
