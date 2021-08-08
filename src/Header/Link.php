<?php
declare(strict_types = 1);

namespace Innmind\Http\Header;

use Innmind\Http\Header as HeaderInterface;

/**
 * @extends Header<LinkValue>
 * @implements HeaderInterface<LinkValue>
 * @psalm-immutable
 */
final class Link extends Header implements HeaderInterface
{
    public function __construct(LinkValue ...$values)
    {
        parent::__construct('Link', ...$values);
    }
}
