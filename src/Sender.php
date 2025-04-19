<?php
declare(strict_types = 1);

namespace Innmind\Http;

use Innmind\Immutable\{
    Attempt,
    SideEffect,
};

interface Sender
{
    /**
     * @return Attempt<SideEffect>
     */
    public function __invoke(Response $response): Attempt;
}
