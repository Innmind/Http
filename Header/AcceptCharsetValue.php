<?php
declare(strict_types = 1);

namespace Innmind\Http\Header;

use Innmind\Http\Exception\InvalidArgumentException;
use Innmind\Immutable\StringPrimitive as Str;

final class AcceptCharsetValue extends HeaderValue
{
    private $quality;

    public function __construct(string $charset, Quality $quality)
    {
        $charset = new Str($charset);

        if (
            (string) $charset !== '*' &&
            !$charset->match('~^[a-zA-Z0-9\-_:\(\)]+$~')
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
