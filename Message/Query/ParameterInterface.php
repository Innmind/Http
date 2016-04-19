<?php
declare(strict_types = 1);

namespace Innmind\Http\Message\Query;

interface ParameterInterface
{
    public function name(): string;

    /**
     * @return mixed
     */
    public function value();
}
