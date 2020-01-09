<?php
declare(strict_types = 1);

namespace Innmind\Http\Header\Parameter;

use Innmind\Http\Header\Parameter as ParameterInterface;
use Innmind\Immutable\Str;

class Parameter implements ParameterInterface
{
    private $name;
    private $value;
    private $string;

    public function __construct(string $name, string $value)
    {
        $value = (new Str($value))->trim();

        if ($value->matches("/[ \t]/")) {
            $value = $value
                ->trim('"')
                ->append('"')
                ->prepend('"');
        }

        $this->name = $name;
        $this->value = (string) $value;
        $this->string = sprintf(
            '%s%s%s',
            $this->name,
            strlen($this->value) > 0 ? '=' : '',
            strlen($this->value) > 0 ? $this->value : ''
        );
    }

    public function name(): string
    {
        return $this->name;
    }

    public function value(): string
    {
        return $this->value;
    }

    public function toString(): string
    {
        return $this->string;
    }
}
