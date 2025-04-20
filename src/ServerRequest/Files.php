<?php
declare(strict_types = 1);

namespace Innmind\Http\ServerRequest;

use Innmind\Http\File\Status;
use Innmind\Filesystem\File;
use Innmind\Immutable\{
    Sequence,
    Either,
};

/**
 * @psalm-immutable
 */
final class Files
{
    private function __construct(
        private array $files,
    ) {
    }

    /**
     * @psalm-pure
     */
    public static function of(array $files): self
    {
        return new self($files);
    }

    /**
     * @param int|non-empty-string $key
     *
     * @return Either<Status, File>
     */
    public function get(int|string $key): Either
    {
        if (!\array_key_exists($key, $this->files)) {
            /** @var Either<Status, File> */
            return Either::left(Status::notUploaded);
        }

        $data = $this->files[$key];

        if (!$data instanceof Either) {
            /** @var Either<Status, File> */
            return Either::left(Status::notUploaded);
        }

        /** @var Either<Status, File> */
        return $data
            ->filter(
                static fn($right) => $right instanceof File,
                static fn() => Status::notUploaded,
            )
            ->leftMap(static fn($left) => match ($left instanceof Status) {
                true => $left,
                false => Status::notUploaded,
            });
    }

    /**
     * @param non-empty-string $name
     */
    public function under(string $name): self
    {
        /** @var mixed */
        $under = $this->files[$name] ?? [];

        if (\is_array($under)) {
            return new self($under);
        }

        return new self([]);
    }

    /**
     * Files that failed to be uploaded won't be listed
     *
     * @param non-empty-string $name
     *
     * @return Sequence<File>
     */
    public function list(string $name): Sequence
    {
        /** @var mixed */
        $under = $this->files[$name] ?? [];

        if (!\is_array($under)) {
            $under = [];
        }

        if (!\array_is_list($under)) {
            $under = [];
        }

        /**
         * @psalm-suppress MixedArgumentTypeCoercion Psalm doesn't understand the filter
         * @var Sequence<File>
         */
        return Sequence::of(...$under)
            ->filter(static fn($value) => $value instanceof Either)
            ->map(static fn(Either $either): mixed => $either->match(
                static fn(mixed $right): mixed => $right,
                static fn() => null, // discard errors
            ))
            ->filter(static fn($right) => $right instanceof File);
    }
}
