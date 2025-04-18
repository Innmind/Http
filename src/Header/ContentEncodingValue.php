<?php
declare(strict_types = 1);

namespace Innmind\Http\Header;

use Innmind\Http\Exception\DomainException;
use Innmind\Immutable\{
    Str,
    Maybe,
};

/**
 * @psalm-immutable
 */
final class ContentEncodingValue implements Value
{
    private string $coding;

    public function __construct(string $coding)
    {
        if (!Str::of($coding)->matches('~^[\w\-]+$~')) {
            throw new DomainException($coding);
        }

        $this->coding = $coding;
    }

    /**
     * @psalm-pure
     *
     * @return Maybe<self>
     */
    public static function of(string $coding): Maybe
    {
        try {
            return Maybe::just(new self($coding));
        } catch (DomainException $e) {
            /** @var Maybe<self> */
            return Maybe::nothing();
        }
    }

    #[\Override]
    public function toString(): string
    {
        return $this->coding;
    }
}
