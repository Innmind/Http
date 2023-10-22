<?php
declare(strict_types = 1);

namespace Innmind\Http;

use Innmind\Immutable\Maybe;

/**
 * @psalm-immutable
 */
enum Method
{
    case get;
    case post;
    case put;
    case patch;
    case delete;
    case options;
    case trace;
    case connect;
    case head;
    case link;
    case unlink;

    /**
     * @psalm-pure
     * @throws \UnhandledMatchError
     */
    public static function of(string $method): self
    {
        return match ($method) {
            'GET' => self::get,
            'POST' => self::post,
            'PUT' => self::put,
            'PATCH' => self::patch,
            'DELETE' => self::delete,
            'OPTIONS' => self::options,
            'TRACE' => self::trace,
            'CONNECT' => self::connect,
            'HEAD' => self::head,
            'LINK' => self::link,
            'UNLINK' => self::unlink,
        };
    }

    /**
     * @psalm-pure
     *
     * @return Maybe<self>
     */
    public static function maybe(string $method): Maybe
    {
        try {
            return Maybe::just(self::of($method));
        } catch (\UnhandledMatchError $e) {
            /** @var Maybe<self> */
            return Maybe::nothing();
        }
    }

    public function safe(): bool
    {
        return match ($this) {
            self::get => true,
            self::post => false,
            self::put => false,
            self::patch => false,
            self::delete => false,
            self::options => true,
            self::trace => true,
            self::connect => false,
            self::head => true,
            self::link => false,
            self::unlink => false,
        };
    }

    public function idempotent(): bool
    {
        return match ($this) {
            self::get => true,
            self::post => false,
            self::put => true,
            self::patch => false,
            self::delete => true,
            self::options => true,
            self::trace => true,
            self::connect => false,
            self::head => true,
            self::link => false,
            self::unlink => false,
        };
    }

    public function toString(): string
    {
        return match ($this) {
            self::get => 'GET',
            self::post => 'POST',
            self::put => 'PUT',
            self::patch => 'PATCH',
            self::delete => 'DELETE',
            self::options => 'OPTIONS',
            self::trace => 'TRACE',
            self::connect => 'CONNECT',
            self::head => 'HEAD',
            self::link => 'LINK',
            self::unlink => 'UNLINK',
        };
    }
}
