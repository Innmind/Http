<?php
declare(strict_types = 1);

namespace Innmind\Http;

interface Sender
{
    public function __invoke(Response $response): void;
}
