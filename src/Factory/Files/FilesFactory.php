<?php
declare(strict_types = 1);

namespace Innmind\Http\Factory\Files;

use Innmind\Http\{
    Factory\FilesFactory as FilesFactoryInterface,
    Message\Files,
    File\Status,
    Exception\LogicException,
};
use Innmind\MediaType\MediaType;
use Innmind\Filesystem\{
    File,
    File\Content,
};
use Innmind\Url\Path;
use Innmind\Immutable\{
    Map,
    Either,
};

/**
 * @psalm-immutable
 * @psalm-type Global = array<string, array{name: string, tmp_name: string, error: int, type: string}|array{name: list<string|array>, tmp_name: list<string|array>, error: list<int|array>, type: list<string|array>}>
 */
final class FilesFactory implements FilesFactoryInterface
{
    /** @var Global */
    private array $files;

    /**
     * @param Global $files
     */
    public function __construct(array $files)
    {
        $this->files = $files;
    }

    public function __invoke(): Files
    {
        /** @var Map<string, Either<Status, File>> */
        $files = Map::of();

        foreach ($this->files as $name => $content) {
            if (!\is_string($content['name'])) {
                throw new LogicException('Nested uploads are not supported');
            }

            /**
             * @psalm-suppress PossiblyInvalidArgument
             * @psalm-suppress PossiblyInvalidCast
             */
            $files = ($files)($name, $this->buildFile(
                $content['name'],
                $content['tmp_name'],
                $content['error'],
                $content['type'],
            ));
        }

        return new Files($files);
    }

    public static function default(): self
    {
        /** @var Global */
        $files = $_FILES;

        return new self($files);
    }

    /**
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

        /** @var Either<Status, File> */
        return Either::right(File\File::named(
            $name,
            Content\AtPath::of(Path::of($path)),
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
