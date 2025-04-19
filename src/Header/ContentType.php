<?php
declare(strict_types = 1);

namespace Innmind\Http\Header;

use Innmind\Http\Header as HeaderInterface;
use Innmind\Immutable\Sequence;

/**
 * @psalm-immutable
 */
final class ContentType implements HeaderInterface
{
    public function __construct(
        private ContentTypeValue $content,
    ) {
    }

    /**
     * @psalm-pure
     */
    public static function of(
        string $type,
        string $subType,
        Parameter ...$parameters,
    ): self {
        return new self(new ContentTypeValue(
            $type,
            $subType,
            ...$parameters,
        ));
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

    public function content(): ContentTypeValue
    {
        return $this->content;
    }

    #[\Override]
    public function toString(): string
    {
        return $this->header()->toString();
    }

    private function header(): Header
    {
        return new Header('Content-Type', $this->content);
    }
}
