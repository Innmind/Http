<?php
declare(strict_types = 1);

namespace Innmind\Http\Header;

use Innmind\Http\Exception\InvalidArgumentException;
use Innmind\Immutable\StringPrimitive as Str;

final class AcceptValue extends HeaderValue
{
    const PATTERN = '~^(\*/\*|[\w\-.]+/[\w\-.\*]+)(; ?\w+=[\w\-.]+)?$~';
    private $quality;

    public function __construct(string $value)
    {
        $value = new Str($value);

        if (!$value->match(self::PATTERN)) {
            throw new InvalidArgumentException;
        }

        parent::__construct((string) $value);
        $matches = $value->getMatches('~; ?q=(?<quality>\d+(\.\d+)?)~');

        if ($matches->hasKey('quality')) {
            $this->quality = new Quality(
                (string) $matches->get('quality')
            );
        } else {
            $this->quality = new Quality('1');
        }
    }

    public function quality(): Quality
    {
        return $this->quality;
    }
}
