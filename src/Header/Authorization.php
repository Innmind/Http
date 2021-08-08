<?php
declare(strict_types = 1);

namespace Innmind\Http\Header;

use Innmind\Http\Header as HeaderInterface;
use Innmind\Immutable\Set;

/**
 * @implements HeaderInterface<AuthorizationValue>
 * @psalm-immutable
 */
final class Authorization implements HeaderInterface
{
    /** @var Header<AuthorizationValue> */
    private Header $header;

    public function __construct(AuthorizationValue $authorization)
    {
        $this->header = new Header('Authorization', $authorization);
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

    public function toString(): string
    {
        return $this->header->toString();
    }
}
