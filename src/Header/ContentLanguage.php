<?php
declare(strict_types = 1);

namespace Innmind\Http\Header;

final class ContentLanguage extends Header
{
    public function __construct(ContentLanguageValue ...$values)
    {
        parent::__construct('Content-Language', ...$values);
    }
}
