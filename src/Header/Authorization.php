<?php
declare(strict_types = 1);

namespace Innmind\Http\Header;

use Innmind\Http\Header as HeaderInterface;
use Innmind\Immutable\Sequence;

/**
 * @psalm-immutable
 */
final class Authorization implements HeaderInterface
{
    public function __construct(
        private AuthorizationValue $value,
    ) {
    }

    /**
     * @psalm-pure
     */
    public static function of(string $scheme, string $parameter): self
    {
        return new self(new AuthorizationValue($scheme, $parameter));
    }

    #[\Override]
    public function name(): string
    {
        return $this->header()->name();
    }

    #[\Override]
    public function values(): Sequence
    {
        return $this->header()->values();
    }

    public function scheme(): string
    {
        return $this->value->scheme();
    }

    public function parameter(): string
    {
        return $this->value->parameter();
    }

    #[\Override]
    public function toString(): string
    {
        return $this->header()->toString();
    }

    private function header(): Header
    {
        return new Header('Authorization', $this->value);
    }
}
