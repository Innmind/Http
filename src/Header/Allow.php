<?php
declare(strict_types = 1);

namespace Innmind\Http\Header;

/**
 * @psalm-immutable
 */
final class Allow implements Provider
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
    public function toHeader(): Header
    {
        return $this->header;
    }
}
