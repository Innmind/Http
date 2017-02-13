<?php
declare(strict_types = 1);

namespace Innmind\Http\Header\CacheControlValue;

use Innmind\Http\{
    Header\CacheControlValueInterface,
    Exception\InvalidArgumentException
};
use Innmind\Immutable\Str;

final class NoCache implements CacheControlValueInterface
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
            'no-cache%s',
            !empty($this->field) ? '="'.$this->field.'"' : ''
        );
    }
}
