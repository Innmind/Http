<?php
declare(strict_types = 1);

namespace Innmind\Http\Factory;

use Innmind\Http\Message\CookiesInterface;

interface CookiesFactoryInterface
{
    public function make(): CookiesInterface;
}
