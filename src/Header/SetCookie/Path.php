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
    public static function of(UrlPath $path): self
    {
        return new self($path);
    }

    public function path(): UrlPath
    {
        return $this->path;
    }

    public function toParameter(): Parameter
    {
        return new Parameter\Parameter('Path', $this->path->toString());
    }
}
