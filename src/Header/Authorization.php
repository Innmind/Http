<?php
declare(strict_types = 1);

namespace Innmind\Http\Header;

use Innmind\Http\Header as HeaderInterface;
use Innmind\Immutable\Set;

/**
 * @psalm-immutable
 */
final class Authorization implements HeaderInterface
{
    private Header $header;
    private AuthorizationValue $value;

    public function __construct(AuthorizationValue $authorization)
    {
        $this->header = new Header('Authorization', $authorization);
        $this->value = $authorization;
    }

    /**
     * @psalm-pure
     */
    public static function of(string $scheme, string $parameter): self
    {
        return new self(new AuthorizationValue($scheme, $parameter));
    }

    public function name(): string
    {
        return $this->header->name();
    }

    public function values(): Set
    {
        return $this->header->values();
    }

    public function scheme(): string
    {
        return $this->value->scheme();
    }

    public function parameter(): string
    {
        return $this->value->parameter();
    }

    public function toString(): string
    {
        return $this->header->toString();
    }
}
