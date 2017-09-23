<?php
declare(strict_types = 1);

namespace Innmind\Http\Header;

use Innmind\Http\{
    Header as HeaderInterface,
    Exception\InvalidArgumentException
};
use Innmind\Immutable\{
    SetInterface,
    Set
};

class Header implements HeaderInterface
{
    private $name;
    private $values;

    public function __construct(string $name, SetInterface $values = null)
    {
        $values = $values ?? new Set(Value::class);

        if ((string) $values->type() !== Value::class) {
            throw new \TypeError(sprintf(
                'Argument 2 must be of type SetInterface<%s>',
                Value::class
            ));
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
