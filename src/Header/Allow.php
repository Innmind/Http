<?php
declare(strict_types = 1);

namespace Innmind\Http\Header;

use Innmind\Http\Header as HeaderInterface;

/**
 * @extends Header<AllowValue>
 * @implements HeaderInterface<AllowValue>
 * @psalm-immutable
 */
final class Allow extends Header implements HeaderInterface
{
    /**
     * @no-named-arguments
     */
    public function __construct(AllowValue ...$values)
    {
        parent::__construct('Allow', ...$values);
    }

    /**
     * @no-named-arguments
     */
    public static function of(string ...$values): self
    {
        return new self(...\array_map(
            static fn(string $value): AllowValue => new AllowValue($value),
            $values,
        ));
    }
}
