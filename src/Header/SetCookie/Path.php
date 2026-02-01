<?php
declare(strict_types = 1);

namespace Innmind\Http\Header\SetCookie;

use Innmind\Http\Header\Parameter;
use Innmind\Url\Path as UrlPath;

/**
 * @psalm-immutable
 */
final class Path
{
    private function __construct(
        private UrlPath $path,
    ) {
    }

    /**
     * @psalm-pure
     */
    #[\NoDiscard]
    public static function of(UrlPath $path): self
    {
        return new self($path);
    }

    #[\NoDiscard]
    public function path(): UrlPath
    {
        return $this->path;
    }

    #[\NoDiscard]
    public function toParameter(): Parameter
    {
        return Parameter::of('Path', $this->path->toString());
    }
}
