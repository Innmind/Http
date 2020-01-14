<?php
declare(strict_types = 1);

namespace Innmind\Http\Header;

use Innmind\Http\{
    Header\Parameter\Quality,
    Exception\DomainException,
};
use Innmind\Immutable\Str;

final class AcceptCharsetValue extends Value\Value
{
    private Quality $quality;

    public function __construct(string $charset, Quality $quality = null)
    {
        $charset = Str::of($charset);
        $quality = $quality ?? new Quality(1);

        if (
            $charset->toString() !== '*' &&
            !$charset->matches('~^[a-zA-Z0-9\-_:\(\)]+$~')
        ) {
            throw new DomainException($charset->toString());
        }

        $this->quality = $quality;
        parent::__construct(
            $charset
                ->append(';')
                ->append($quality->toString())
                ->toString(),
        );
    }

    public function quality(): Quality
    {
        return $this->quality;
    }
}
