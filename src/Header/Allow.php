<?php
declare(strict_types = 1);

namespace Innmind\Http\Header;

use Innmind\Http\Header as HeaderInterface;

/**
 * @extends Header<AllowValue>
 * @implements HeaderInterface<AllowValue>
 */
final class Allow extends Header implements HeaderInterface
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
