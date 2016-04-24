<?php
declare(strict_types = 1);

namespace Innmind\Http\Message;

use Innmind\Http\Exception\InvalidArgumentException;

final class ReasonPhrase implements ReasonPhraseInterface
{
    private $phrase;

    public function __construct(string $phrase)
    {
        if ($phrase === '') {
            throw new InvalidArgumentException;
        }

        $this->phrase = $phrase;
    }

    public function __toString(): string
    {
        return $this->phrase;
    }
}
