<?php
declare(strict_types = 1);

namespace Innmind\Http\Header;

use Innmind\Http\{
    Header\Parameter\Quality,
    Exception\InvalidArgumentException
};
use Innmind\Immutable\Str;

final class AcceptCharsetValue extends HeaderValue\HeaderValue
{
    private $quality;

    public function __construct(string $charset, Quality $quality = null)
    {
        $charset = new Str($charset);
        $quality = $quality ?? new Quality(1);

        if (
            (string) $charset !== '*' &&
            !$charset->matches('~^[a-zA-Z0-9\-_:\(\)]+$~')
        ) {
            throw new InvalidArgumentException;
        }

        $this->quality = $quality;
        parent::__construct(
            (string) $charset
                ->append(';')
                ->append((string) $quality)
        );
    }

    public function quality(): Quality
    {
        return $this->quality;
    }
}
