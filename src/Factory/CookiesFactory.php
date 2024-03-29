<?php
declare(strict_types = 1);

namespace Innmind\Http\Factory;

use Innmind\Http\ServerRequest\Cookies;

/**
 * @psalm-immutable
 */
interface CookiesFactory
{
    public function __invoke(): Cookies;
}
