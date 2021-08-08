<?php
declare(strict_types = 1);

namespace Innmind\Http\Header;

use Innmind\Http\Header as HeaderInterface;

/**
 * @extends Header<AgeValue>
 * @implements HeaderInterface<AgeValue>
 * @psalm-immutable
 */
final class Age extends Header implements HeaderInterface
{
    public function __construct(AgeValue $age)
    {
        parent::__construct('Age', $age);
    }

    public static function of(int $age): self
    {
        return new self(new AgeValue($age));
    }
}
