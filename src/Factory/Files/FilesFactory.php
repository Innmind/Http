<?php
declare(strict_types = 1);

namespace Innmind\Http\Factory\Files;

use Innmind\Http\{
    Factory\FilesFactory as FilesFactoryInterface,
    Message\Files,
    File,
    File\Status\ExceedsFormMaxFileSize,
    File\Status\ExceedsIniMaxFileSize,
    File\Status\NoTemporaryDirectory,
    File\Status\NotUploaded,
    File\Status\Ok,
    File\Status\PartiallyUploaded,
    File\Status\StoppedByExtension,
    File\Status\WriteFailed,
    File\Status,
    Exception\LogicException,
};
use Innmind\MediaType\MediaType;
use Innmind\Filesystem\File\Content;
use Innmind\Url\Path;
use Innmind\Immutable\{
    Map,
    Either,
};

final class FilesFactory implements FilesFactoryInterface
{
    public function __invoke(): Files
    {
        $map = [];

        /**
         * @var string $name
         * @var array{name: string, tmp_name: string, error: int, type: string}|array{name: list<string|array>, tmp_name: list<string|array>, error: list<int|array>, type: list<string|array>} $content
         */
        foreach ($_FILES as $name => $content) {
            if (!\is_string($content['name'])) {
                throw new LogicException('Nested uploads are not supported');
            }

            /**
             * @psalm-suppress PossiblyInvalidArgument
             * @psalm-suppress PossiblyInvalidCast
             */
            $map[] = $this->buildFile(
                $content['name'],
                $content['tmp_name'],
                $content['error'],
                $content['type'],
                $name,
            );
        }

        /** @var Map<string, File> */
        $files = Map::of();

        foreach ($map as $file) {
            $files = ($files)($file->uploadKey(), $file);
        }

        /** @var Map<string, Either<Status, File>> */
        $files = $files->map(
            static fn($_, $file) => $file->status() instanceof Ok
                ? Either::right($file)
                : Either::left($file->status()),
        );

        return new Files($files);
    }

    private function buildFile(
        string $name,
        string $path,
        int $status,
        string $media,
        string $uploadKey
    ): File {
        return new File\File(
            $name,
            Content\AtPath::of(Path::of($path)),
            $uploadKey,
            $this->status($status),
            MediaType::of($media)->match(
                static fn($media) => $media,
                static fn() => MediaType::null(),
            ),
        );
    }

    private function status(int $status): Status
    {
        switch ($status) {
            case \UPLOAD_ERR_FORM_SIZE:
                return new ExceedsFormMaxFileSize;
            case \UPLOAD_ERR_INI_SIZE:
                return new ExceedsIniMaxFileSize;
            case \UPLOAD_ERR_NO_TMP_DIR:
                return new NoTemporaryDirectory;
            case \UPLOAD_ERR_NO_FILE:
                return new NotUploaded;
            case \UPLOAD_ERR_OK:
                return new Ok;
            case \UPLOAD_ERR_PARTIAL:
                return new PartiallyUploaded;
            case \UPLOAD_ERR_EXTENSION:
                return new StoppedByExtension;
            case \UPLOAD_ERR_CANT_WRITE:
                return new WriteFailed;
        }

        throw new LogicException("Unknown file upload status $status");
    }
}
