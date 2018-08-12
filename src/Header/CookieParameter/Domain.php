<?php
declare(strict_types = 1);

namespace Innmind\Http\Header\CookieParameter;

use Innmind\Http\Header\Parameter\Parameter;
use Innmind\Url\Authority\HostInterface;

final class Domain extends Parameter
{
    public function __construct(HostInterface $host)
    {
        parent::__construct('Domain', (string) $host);
    }
}
