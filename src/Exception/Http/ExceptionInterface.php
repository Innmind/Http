<?php
declare(strict_types = 1);

namespace Innmind\Http\Exception\Http;

use Innmind\Http\Exception\ExceptionInterface as Base;

interface ExceptionInterface extends Base
{
    public function httpCode(): int;
}
