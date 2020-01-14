<?php
declare(strict_types = 1);

namespace Innmind\Http\Header\CookieParameter;

use Innmind\Http\Header\Parameter\Parameter;
use Innmind\Url\Path as UrlPath;

final class Path extends Parameter
{
    public function __construct(UrlPath $path)
    {
        parent::__construct('Path', $path->toString());
    }
}
