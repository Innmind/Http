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
    File\Status
};
use Innmind\Filesystem\MediaType\MediaType;
use Innmind\Stream\Readable\Stream;
use Innmind\Immutable\{
    Map,
    Str
};

final class FilesFactory implements FilesFactoryInterface
{
    public function make(): Files
    {
        $map = new Map('string', File::class);

        foreach ($_FILES as $name => $content) {
            if (is_array($content['name'])) {
                foreach ($content['name'] as $subName => $filename) {
                    $map = $map->put(
                        $name.'.'.$subName,
                        $this->buildFile(
                            $content['name'][$subName],
                            $content['tmp_name'][$subName],
                            $content['error'][$subName],
                            $content['type'][$subName]
                        )
                    );
                }

                continue;
            }

            $map = $map->put(
                $name,
                $this->buildFile(
                    $content['name'],
                    $content['tmp_name'],
                    $content['error'],
                    $content['type']
                )
            );
        }

        return new Files\Files($map);
    }

    private function buildFile(
        string $name,
        string $path,
        int $status,
        string $media
    ): File {
        $media = (new Str($media))->split('/');

        return new File\File(
            $name,
            new Stream(fopen($path, 'r')),
            $this->status($status),
            new MediaType(
                (string) $media->get(0),
                (string) $media->get(1)
            )
        );
    }

    private function status(int $status): Status
    {
        switch ($status) {
            case UPLOAD_ERR_FORM_SIZE:
                return new ExceedsFormMaxFileSize;
            case UPLOAD_ERR_INI_SIZE:
                return new ExceedsIniMaxFileSize;
            case UPLOAD_ERR_NO_TMP_DIR:
                return new NoTemporaryDirectory;
            case UPLOAD_ERR_NO_FILE:
                return new NotUploaded;
            case UPLOAD_ERR_OK:
                return new Ok;
            case UPLOAD_ERR_PARTIAL:
                return new PartiallyUploaded;
            case UPLOAD_ERR_EXTENSION:
                return new StoppedByExtension;
            case UPLOAD_ERR_CANT_WRITE:
                return new WriteFailed;
        }
    }
}
