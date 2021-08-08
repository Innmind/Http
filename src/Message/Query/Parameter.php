<?php
declare(strict_types = 1);

namespace Innmind\Http\Message\Query;

use Innmind\Http\Exception\DomainException;

/**
 * @psalm-immutable
 */
final class Parameter
{
    private string $name;
    /** @var string|array */
    private $value;

    /**
     * @param string|array $value
     */
    public function __construct(string $name, $value)
    {
        if ($name === '') {
            throw new DomainException('Parameter name can\'t be empty');
        }

        $this->name = $name;
        $this->value = $value;
    }

    public function name(): string
    {
        return $this->name;
    }

    /**
     * @return string|array
     */
    public function value()
    {
        return $this->value;
    }
}
