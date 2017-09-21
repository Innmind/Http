<?php
declare(strict_types = 1);

namespace Innmind\Http\Factory;

use Innmind\Http\Message\Cookies;

interface CookiesFactory
{
    public function make(): Cookies;
}
