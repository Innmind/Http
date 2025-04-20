<?php
declare(strict_types = 1);

namespace Innmind\Http\Header\CacheControl;

use Innmind\Immutable\{
    Str,
    Maybe,
};

/**
 * @psalm-immutable
 */
final class PrivateCache
{
    private function __construct(
        private string $field,
    ) {
    }

    /**
     * @psalm-pure
     *
     * @return Maybe<self>
     */
    public static function maybe(string $field): Maybe
    {
        if (!Str::of($field)->matches('~^\w*$~')) {
            /** @var Maybe<self> */
            return Maybe::nothing();
        }

        return Maybe::just(new self($field));
    }

    public function field(): string
    {
        return $this->field;
    }

    public function toString(): string
    {
        return \sprintf(
            'private%s',
            !empty($this->field) ? '="'.$this->field.'"' : '',
        );
    }
}
