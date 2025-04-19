<?php
declare(strict_types = 1);

namespace Innmind\Http\Header;

use Innmind\MediaType\MediaType;
use Innmind\Immutable\Str;

/**
 * @psalm-immutable
 */
final class ContentType implements Provider
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

    public function content(): MediaType
    {
        return $this->content;
    }

    #[\Override]
    public function toHeader(): Header
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
