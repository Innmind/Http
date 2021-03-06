<?php
declare(strict_types = 1);

namespace Innmind\Http\Header\CacheControlValue;

use Innmind\Http\{
    Header\CacheControlValue,
    Exception\DomainException,
};
use Innmind\Immutable\Str;

final class NoCache implements CacheControlValue
{
    private string $field;

    public function __construct(string $field)
    {
        if (!Str::of($field)->matches('~^\w*$~')) {
            throw new DomainException($field);
        }

        $this->field = $field;
    }

    public function field(): string
    {
        return $this->field;
    }

    public function toString(): string
    {
        return \sprintf(
            'no-cache%s',
            !empty($this->field) ? '="'.$this->field.'"' : '',
        );
    }
}
