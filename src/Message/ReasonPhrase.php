<?php
declare(strict_types = 1);

namespace Innmind\Http\Message;

interface ReasonPhrase
{
    public function __toString(): string;
}
