<?php
declare(strict_types = 1);

namespace Innmind\Http\Header;

use Innmind\Http\Header as HeaderInterface;
use Innmind\Immutable\Set;

/**
 * @psalm-immutable
 */
final class ContentType implements HeaderInterface
{
    private Header $header;
    private ContentTypeValue $content;

    public function __construct(ContentTypeValue $content)
    {
        $this->header = new Header('Content-Type', $content);
        $this->content = $content;
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

    public function name(): string
    {
        return $this->header->name();
    }

    public function values(): Set
    {
        return $this->header->values();
    }

    public function content(): ContentTypeValue
    {
        return $this->content;
    }

    public function toString(): string
    {
        return $this->header->toString();
    }
}
