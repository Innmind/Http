<?php
declare(strict_types = 1);

namespace Innmind\Http\Header;

use Innmind\Http\Exception\InvalidArgumentException;
use Innmind\Immutable\StringPrimitive as Str;

final class AcceptEncodingValue extends HeaderValue
{
    private $quality;

    public function __construct(string $coding, Quality $quality)
    {
        $coding = new Str($coding);

        if (
            (string) $coding !== '*' &&
            !$coding->match('~^\w+$~')
        ) {
            throw new InvalidArgumentException;
        }

        $this->quality = $quality;
        parent::__construct(
            (string) $coding
                ->append(';')
                ->append((string) $quality)
        );
    }

    public function quality(): Quality
    {
        return $this->quality;
    }
}
