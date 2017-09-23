<?php
declare(strict_types = 1);

namespace Innmind\Http\Header;

final class ContentType extends Header
{
    public function __construct(ContentTypeValue $content)
    {
        parent::__construct('Content-Type', $content);
    }
}
