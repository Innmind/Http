<?php
declare(strict_types = 1);

namespace Innmind\Http\Response;

use Innmind\Http\Response;
use Innmind\Immutable\{
    Attempt,
    SideEffect,
};

interface Sender
{
    /**
     * @return Attempt<SideEffect>
     */
    #[\NoDiscard]
    public function __invoke(Response $response): Attempt;
}
