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
final class NoCache
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
    #[\NoDiscard]
    public static function maybe(string $field): Maybe
    {
        if (!Str::of($field)->matches('~^\w*$~')) {
            /** @var Maybe<self> */
            return Maybe::nothing();
        }

        return Maybe::just(new self($field));
    }

    #[\NoDiscard]
    public function field(): string
    {
        return $this->field;
    }

    #[\NoDiscard]
    public function toString(): string
    {
        return \sprintf(
            'no-cache%s',
            !empty($this->field) ? '="'.$this->field.'"' : '',
        );
    }
}
