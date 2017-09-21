<?php
declare(strict_types = 1);

namespace Innmind\Http\Factory\Files;

use Innmind\Http\{
    Factory\FilesFactory as FilesFactoryInterface,
    Message\Files,
    File,
    File\Status\ExceedsFormMaxFileSizeStatus,
    File\Status\ExceedsIniMaxFileSizeStatus,
    File\Status\NoTemporaryDirectoryStatus,
    File\Status\NotUploadedStatus,
    File\Status\OkStatus,
    File\Status\PartiallyUploadedStatus,
    File\Status\StoppedByExtensionStatus,
    File\Status\WriteFailedStatus,
    File\Status
};
use Innmind\Filesystem\{
    Stream\Stream,
    MediaType\MediaType
};
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
                return new ExceedsFormMaxFileSizeStatus;
            case UPLOAD_ERR_INI_SIZE:
                return new ExceedsIniMaxFileSizeStatus;
            case UPLOAD_ERR_NO_TMP_DIR:
                return new NoTemporaryDirectoryStatus;
            case UPLOAD_ERR_NO_FILE:
                return new NotUploadedStatus;
            case UPLOAD_ERR_OK:
                return new OkStatus;
            case UPLOAD_ERR_PARTIAL:
                return new PartiallyUploadedStatus;
            case UPLOAD_ERR_EXTENSION:
                return new StoppedByExtensionStatus;
            case UPLOAD_ERR_CANT_WRITE:
                return new WriteFailedStatus;
        }
    }
}
