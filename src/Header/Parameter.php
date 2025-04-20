<?php
declare(strict_types = 1);

namespace Innmind\Http\Header;

use Innmind\Immutable\Str;

/**
 * @psalm-immutable
 */
final class Parameter
{
    private string $name;
    private string $value;

    private function __construct(string $name, string $value)
    {
        $value = Str::of($value)->trim();

        if ($value->matches("/[ \t]/")) {
            $value = $value
                ->trim('"')
                ->append('"')
                ->prepend('"');
        }

        $this->name = $name;
        $this->value = $value->toString();
    }

    /**
     * @psalm-pure
     */
    public static function of(string $name, string $value): self
    {
        return new self($name, $value);
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
        return \sprintf(
            '%s%s%s',
            $this->name,
            \strlen($this->value) > 0 ? '=' : '',
            \strlen($this->value) > 0 ? $this->value : '',
        );
    }
}
