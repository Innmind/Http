<?php
declare(strict_types = 1);

namespace Innmind\Http;

use Innmind\Http\Message\Response;

interface Sender
{
    public function __invoke(Response $response): void;
}
