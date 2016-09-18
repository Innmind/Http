<?php
declare(strict_types = 1);

namespace Innmind\Http\Header;

use Innmind\Http\Exception\InvalidArgumentException;
use Innmind\Immutable\SetInterface;

class Header implements HeaderInterface
{
    private $name;
    private $values;

    public function __construct(string $name, SetInterface $values)
    {
        if ((string) $values->type() !== HeaderValueInterface::class) {
            throw new InvalidArgumentException;
        }

        $this->name = $name;
        $this->values = $values;
    }

    public function name(): string
    {
        return $this->name;
    }

    /**
     * {@inheritdoc}
     */
    public function values(): SetInterface
    {
        return $this->values;
    }

    public function __toString(): string
    {
        return sprintf(
            '%s : %s',
            $this->name,
            $this->values->join(', ')
        );
    }
}
