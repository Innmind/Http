<?php
declare(strict_types = 1);

namespace Innmind\Http\Header;

use Innmind\Immutable\Set;

final class Referrer extends Header
{
    public function __construct(ReferrerValue $referrer)
    {
        parent::__construct(
            'Referer',
            (new Set(HeaderValueInterface::class))
                ->add($referrer)
        );
    }
}
