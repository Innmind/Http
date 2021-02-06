<?php
declare(strict_types = 1);

namespace Innmind\Http\Header;

/**
 * @extends Header<AllowValue>
 */
final class Allow extends Header
{
    public function __construct(AllowValue ...$values)
    {
        parent::__construct('Allow', ...$values);
    }

    public static function of(string ...$values): self
    {
        return new self(...\array_map(
            static fn(string $value): AllowValue => new AllowValue($value),
            $values,
        ));
    }
}
