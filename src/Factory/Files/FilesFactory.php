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
};
use Innmind\MediaType\MediaType;
use Innmind\Filesystem\Stream\LazyStream;
use Innmind\Url\Path;
use Innmind\Immutable\Map;

final class FilesFactory implements FilesFactoryInterface
{
    public function __invoke(): Files
    {
        $map = [];

        foreach ($_FILES as $name => $content) {
            if (\is_array($content['name'])) {
                foreach ($content['name'] as $subName => $filename) {
                    $map[] = $this->buildFile(
                        $content['name'][$subName],
                        $content['tmp_name'][$subName],
                        $content['error'][$subName],
                        $content['type'][$subName],
                        $name.'.'.$subName,
                    );
                }

                continue;
            }

            $map[] = $this->buildFile(
                $content['name'],
                $content['tmp_name'],
                $content['error'],
                $content['type'],
                $name,
            );
        }

        return new Files(...$map);
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
            new LazyStream(Path::of($path)),
            $uploadKey,
            $this->status($status),
            MediaType::of($media),
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
    }
}
