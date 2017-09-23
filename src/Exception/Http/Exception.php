<?php
declare(strict_types = 1);

namespace Innmind\Http\Exception\Http;

use Innmind\Http\Exception\Exception as Base;

interface Exception extends Base
{
    public function httpCode(): int;
}
