<?php
declare(strict_types = 1);

namespace Innmind\Http\ServerRequest;

use Innmind\Immutable\Maybe;

/**
 * @psalm-immutable
 */
final class Query implements \Countable
{
    private array $data;

    private function __construct(array $data)
    {
        $this->data = $data;
    }

    /**
     * @psalm-pure
     */
    public static function of(array $data): self
    {
        return new self($data);
    }

    /**
     * @return Maybe<string|array>
     */
    public function get(int|string $key): Maybe
    {
        if (!\array_key_exists($key, $this->data)) {
            /** @var Maybe<string|array> */
            return Maybe::nothing();
        }

        /** @var Maybe<string|array> */
        return Maybe::just($this->data[$key]);
    }

    /**
     * @return Maybe<self>
     */
    public function list(int|string $key): Maybe
    {
        /** @psalm-suppress InvalidArgument Psalm doesn't understand the filters */
        return $this
            ->get($key)
            ->filter(static fn($data) => \is_array($data))
            ->filter(static fn(array $data) => \array_is_list($data))
            ->map(static fn(array $data) => new self($data));
    }

    /**
     * @return Maybe<self>
     */
    public function dictionary(int|string $key): Maybe
    {
        /** @psalm-suppress InvalidArgument Psalm doesn't understand the filters */
        return $this
            ->get($key)
            ->filter(static fn($data) => \is_array($data))
            ->filter(static fn(array $data) => !\array_is_list($data))
            ->map(static fn(array $data) => new self($data));
    }

    public function contains(int|string $key): bool
    {
        return $this->get($key)->match(
            static fn() => true,
            static fn() => false,
        );
    }

    public function data(): array
    {
        return $this->data;
    }

    public function count(): int
    {
        return \count($this->data);
    }
}
