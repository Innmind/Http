<?php
declare(strict_types = 1);

namespace Innmind\Http\Header;

use Innmind\Http\Header as HeaderInterface;
use Innmind\Immutable\Set;

/**
 * @implements HeaderInterface<AcceptLanguageValue>
 * @psalm-immutable
 */
final class AcceptLanguage implements HeaderInterface
{
    /** @var Header<AcceptLanguageValue> */
    private Header $header;

    /**
     * @no-named-arguments
     */
    public function __construct(AcceptLanguageValue ...$values)
    {
        $this->header = new Header('Accept-Language', ...$values);
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
