<?php
declare(strict_types = 1);

namespace Innmind\Http\Header;

use Innmind\Http\Header as HeaderInterface;

/**
 * @extends Header<ContentTypeValue>
 * @implements HeaderInterface<ContentTypeValue>
 * @psalm-immutable
 */
final class ContentType extends Header implements HeaderInterface
{
    public function __construct(ContentTypeValue $content)
    {
        parent::__construct('Content-Type', $content);
    }

    public static function of(
        string $type,
        string $subType,
        Parameter ...$parameters
    ): self {
        return new self(new ContentTypeValue(
            $type,
            $subType,
            ...$parameters,
        ));
    }
}
