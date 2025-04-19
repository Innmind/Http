<?php
declare(strict_types = 1);

namespace Innmind\Http\Header;

use Innmind\Http\Header as HeaderInterface;
use Innmind\MediaType\MediaType;
use Innmind\Immutable\{
    Sequence,
    Str,
};

/**
 * @psalm-immutable
 */
final class ContentType implements HeaderInterface
{
    private function __construct(
        private MediaType $content,
    ) {
    }

    /**
     * @psalm-pure
     */
    public static function of(MediaType $content): self
    {
        return new self($content);
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

    public function content(): MediaType
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
        $mediaType = new MediaType(
            $this->content->topLevel(),
            $this->content->subType(),
            $this->content->suffix(),
        );
        $parameters = Str::of(';')->join(
            $this
                ->content
                ->parameters()
                ->map(static fn($parameter) => new Parameter\Parameter( // to make sure it's of the HTTP format
                    $parameter->name(),
                    $parameter->value(),
                ))
                ->map(static fn($parameter) => $parameter->toString()),
        );

        $content = $mediaType->toString();

        if (!$parameters->empty()) {
            $content .= ';';
        }

        $content .= $parameters->toString();

        return new Header(
            'Content-Type',
            new Value\Value($content),
        );
    }
}
