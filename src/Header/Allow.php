<?php
declare(strict_types = 1);

namespace Innmind\Http\Header;

use Innmind\Http\Header as HeaderInterface;
use Innmind\Immutable\Set;

/**
 * @implements HeaderInterface<AllowValue>
 * @psalm-immutable
 */
final class Allow implements HeaderInterface
{
    /** @var Header<AllowValue> */
    private Header $header;

    /**
     * @no-named-arguments
     */
    public function __construct(AllowValue ...$values)
    {
        $this->header = new Header('Allow', ...$values);
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

    public function name(): string
    {
        return $this->header->name();
    }

    public function values(): Set
    {
        return $this->header->values();
    }

    public function toString(): string
    {
        return $this->header->toString();
    }
}
