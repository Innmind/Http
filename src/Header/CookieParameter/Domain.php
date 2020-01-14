<?php
declare(strict_types = 1);

namespace Innmind\Http\Header\CookieParameter;

use Innmind\Http\Header\Parameter\Parameter;
use Innmind\Url\Authority\Host;

final class Domain extends Parameter
{
    public function __construct(Host $host)
    {
        parent::__construct('Domain', $host->toString());
    }
}
