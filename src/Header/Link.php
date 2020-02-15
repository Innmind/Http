<?php
declare(strict_types = 1);

namespace Innmind\Http\Header;

/**
 * @extends Header<LinkValue>
 */
final class Link extends Header
{
    public function __construct(LinkValue ...$values)
    {
        parent::__construct('Link', ...$values);
    }
}
