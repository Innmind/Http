<?php
declare(strict_types = 1);

namespace Innmind\Http\Header\CacheControlValue;

use Innmind\Http\{
    Header\CacheControlValue,
    Exception\InvalidArgumentException
};
use Innmind\Immutable\Str;

final class PrivateCache implements CacheControlValue
{
    private $field;

    public function __construct(string $field)
    {
        if (!(new Str($field))->matches('~^\w*$~')) {
            throw new InvalidArgumentException;
        }

        $this->field = $field;
    }

    public function field(): string
    {
        return $this->field;
    }

    public function __toString(): string
    {
        return sprintf(
            'private%s',
            !empty($this->field) ? '="'.$this->field.'"' : ''
        );
    }
}
