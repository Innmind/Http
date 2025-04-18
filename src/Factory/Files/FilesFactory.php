<?php
declare(strict_types = 1);

namespace Innmind\Http\Factory\Files;

use Innmind\Http\{
    Factory\FilesFactory as FilesFactoryInterface,
    ServerRequest\Files,
    File\Status,
};
use Innmind\MediaType\MediaType;
use Innmind\Filesystem\{
    File,
    File\Content,
};
use Innmind\Url\Path;
use Innmind\IO\IO;
use Innmind\Immutable\Either;

/**
 * @psalm-immutable
 *
 * The structure of $_FILES is way too weird to describe it as type, so there is
 * a bunch of annotations to suppress Psalm errors because it can't understand
 * the data being passed around
 */
final class FilesFactory implements FilesFactoryInterface
{
    private IO $io;
    private array $files;

    public function __construct(IO $io, array $files)
    {
        $this->io = $io;
        $this->files = $files;
    }

    #[\Override]
    public function __invoke(): Files
    {
        $files = [];

        /** @var array $content */
        foreach ($this->files as $key => $content) {
            $files[$key] = $this->map($content);
        }

        return Files::of($files);
    }

    public static function default(IO $io): self
    {
        return new self($io, $_FILES);
    }

    private function map(array $content): array|Either
    {
        /**
         * @psalm-suppress MixedArgument
         * @psalm-suppress ArgumentTypeCoercion
         */
        if (\is_string($content['name'])) {
            return $this->buildFile(
                $content['name'],
                $content['tmp_name'],
                $content['error'],
                $content['type'],
            );
        }

        $nested = [];

        /** @psalm-suppress MixedAssignment */
        foreach ($content['name'] as $key => $_) {
            /**
             * @psalm-suppress MixedArrayOffset
             * @psalm-suppress MixedArrayAccess
             */
            $nested[$key] = $this->map([
                'name' => $content['name'][$key],
                'tmp_name' => $content['tmp_name'][$key],
                'error' => $content['error'][$key],
                'type' => $content['type'][$key],
            ]);
        }

        return $nested;
    }

    /**
     * @param non-empty-string $name
     *
     * @return Either<Status, File>
     */
    private function buildFile(
        string $name,
        string $path,
        int $status,
        string $media,
    ): Either {
        $status = $this->status($status);

        if (!\is_null($status)) {
            /** @var Either<Status, File> */
            return Either::left($status);
        }

        /**
         * @psalm-suppress ImpureMethodCall
         * @var Either<Status, File>
         */
        return Either::right(File::named(
            $name,
            Content::atPath(
                $this->io,
                Path::of($path),
            ),
            MediaType::maybe($media)->match(
                static fn($media) => $media,
                static fn() => MediaType::null(),
            ),
        ));
    }

    private function status(int $status): ?Status
    {
        return match ($status) {
            \UPLOAD_ERR_FORM_SIZE => Status::exceedsFormMaxFileSize,
            \UPLOAD_ERR_INI_SIZE => Status::exceedsIniMaxFileSize,
            \UPLOAD_ERR_NO_TMP_DIR => Status::noTemporaryDirectory,
            \UPLOAD_ERR_NO_FILE => Status::notUploaded,
            \UPLOAD_ERR_OK => null,
            \UPLOAD_ERR_PARTIAL => Status::partiallyUploaded,
            \UPLOAD_ERR_EXTENSION => Status::stoppedByExtension,
            \UPLOAD_ERR_CANT_WRITE => Status::writeFailed,
        };
    }
}
