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

    private static ?self $get = null;
    private static ?self $post = null;
    private static ?self $put = null;
    private static ?self $patch = null;
    private static ?self $delete = null;
    private static ?self $options = null;
    private static ?self $trace = null;
    private static ?self $connect = null;
    private static ?self $head = null;
    private static ?self $link = null;
    private static ?self $unlink = null;

    private string $method;

    public function __construct(string $method)
    {
        if (!\defined('self::'.$method)) {
            throw new DomainException($method);
        }

        $this->method = $method;
    }

    public static function get(): self
    {
        return self::$get ??= new self(self::GET);
    }

    public static function post(): self
    {
        return self::$post ??= new self(self::POST);
    }

    public static function put(): self
    {
        return self::$put ??= new self(self::PUT);
    }

    public static function patch(): self
    {
        return self::$patch ??= new self(self::PATCH);
    }

    public static function delete(): self
    {
        return self::$delete ??= new self(self::DELETE);
    }

    public static function options(): self
    {
        return self::$options ??= new self(self::OPTIONS);
    }

    public static function trace(): self
    {
        return self::$trace ??= new self(self::TRACE);
    }

    public static function connect(): self
    {
        return self::$connect ??= new self(self::CONNECT);
    }

    public static function head(): self
    {
        return self::$head ??= new self(self::HEAD);
    }

    public static function link(): self
    {
        return self::$link ??= new self(self::LINK);
    }

    public static function unlink(): self
    {
        return self::$unlink ??= new self(self::UNLINK);
    }

    public function toString(): string
    {
        return $this->method;
    }
}
