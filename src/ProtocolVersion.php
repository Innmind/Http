<?php
declare(strict_types = 1);

namespace Innmind\Http;

use Innmind\Immutable\Maybe;

/**
 * @psalm-immutable
 */
enum ProtocolVersion
{
    case v10;
    case v11;
    case v20;

    /**
     * @psalm-pure
     *
     * @return Maybe<self>
     */
    #[\NoDiscard]
    public static function maybe(int $major, int $minor): Maybe
    {
        /** @var Maybe<self> */
        return Maybe::of(match ("$major.$minor") {
            '1.0' => self::v10,
            '1.1' => self::v11,
            '2.0' => self::v20,
            default => null,
        });
    }

    /**
     * @return non-empty-string
     */
    #[\NoDiscard]
    public function toString(): string
    {
        return match ($this) {
            self::v10 => '1.0',
            self::v11 => '1.1',
            self::v20 => '2.0',
        };
    }
}
