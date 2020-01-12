<?php
declare(strict_types = 1);

namespace Innmind\Http\Header;

use Innmind\Http\{
    Header\Parameter\Quality,
    Exception\DomainException
};
use Innmind\Immutable\Str;

final class AcceptEncodingValue extends Value\Value
{
    private ?Quality $quality;

    public function __construct(string $coding, Quality $quality = null)
    {
        $coding = Str::of($coding);
        $quality = $quality ?? new Quality(1);

        if (
            $coding->toString() !== '*' &&
            !$coding->matches('~^\w+$~')
        ) {
            throw new DomainException;
        }

        $this->quality = $quality;
        parent::__construct(
            $coding
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
