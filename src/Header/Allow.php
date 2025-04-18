<?php
declare(strict_types = 1);

namespace Innmind\Http\Header;

use Innmind\Http\Header as HeaderInterface;
use Innmind\Immutable\Set;

/**
 * @psalm-immutable
 */
final class Allow implements HeaderInterface
{
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
     * @psalm-pure
     */
    public static function of(string ...$values): self
    {
        return new self(...\array_map(
            static fn(string $value): AllowValue => new AllowValue($value),
            $values,
        ));
    }

    #[\Override]
    public function name(): string
    {
        return $this->header->name();
    }

    #[\Override]
    public function values(): Set
    {
        return $this->header->values();
    }

    #[\Override]
    public function toString(): string
    {
        return $this->header->toString();
    }
}
