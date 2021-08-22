<?php
declare(strict_types = 1);

namespace Innmind\Http\Header\CacheControlValue;

use Innmind\Http\{
    Header\CacheControlValue,
    Exception\DomainException,
};
use Innmind\Immutable\{
    Str,
    Maybe,
};

/**
 * @psalm-immutable
 */
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

    /**
     * @psalm-pure
     *
     * @return Maybe<self>
     */
    public static function of(string $field): Maybe
    {
        try {
            return Maybe::just(new self($field));
        } catch (DomainException $e) {
            /** @var Maybe<self> */
            return Maybe::nothing();
        }
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
