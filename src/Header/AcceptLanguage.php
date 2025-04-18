<?php
declare(strict_types = 1);

namespace Innmind\Http\Header;

use Innmind\Http\Header as HeaderInterface;
use Innmind\Immutable\Set;

/**
 * @psalm-immutable
 */
final class AcceptLanguage implements HeaderInterface
{
    private Header $header;

    /**
     * @no-named-arguments
     */
    public function __construct(AcceptLanguageValue ...$values)
    {
        $this->header = new Header('Accept-Language', ...$values);
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
