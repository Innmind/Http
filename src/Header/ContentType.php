<?php
declare(strict_types = 1);

namespace Innmind\Http\Header;

use Innmind\Immutable\MapInterface;

final class ContentType extends Header
{
    public function __construct(ContentTypeValue $content)
    {
        parent::__construct('Content-Type', $content);
    }

    public static function of(
        string $type,
        string $subType,
        MapInterface $parameters = null
    ): self {
        return new self(new ContentTypeValue(
            $type,
            $subType,
            $parameters,
        ));
    }
}
