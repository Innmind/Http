<?php
declare(strict_types = 1);

namespace Innmind\Http\Header;

use Innmind\Url\Url;

/**
 * @psalm-immutable
 */
final class ReferrerValue extends Value\Value
{
    public function __construct(Url $url)
    {
        parent::__construct($url->toString());
    }
}
