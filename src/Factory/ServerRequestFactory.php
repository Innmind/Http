<?php
declare(strict_types = 1);

namespace Innmind\Http\Factory;

use Innmind\Http\Message\ServerRequest;

interface ServerRequestFactory
{
    public function __invoke(): ServerRequest;
}
