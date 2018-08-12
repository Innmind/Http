<?php
declare(strict_types = 1);

namespace Innmind\Http\Header\CookieParameter;

use Innmind\Http\Header\Parameter\Parameter;
use Innmind\Url\PathInterface;

final class Path extends Parameter
{
    public function __construct(PathInterface $path)
    {
        parent::__construct('Path', (string) $path);
    }
}
