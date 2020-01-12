<?php
declare(strict_types = 1);

namespace Innmind\Http\File;

use Innmind\Http\File as FileInterface;
use Innmind\Filesystem\{
    Name,
    MediaType
};
use Innmind\Stream\Readable;

final class File implements FileInterface
{
    private Name $name;
    private Readable $content;
    private string $uploadKey;
    private Status $status;
    private MediaType $mediaType;

    public function __construct(
        string $name,
        Readable $content,
        string $uploadKey,
        Status $status,
        MediaType $mediaType
    ) {
        $this->name = new Name\Name($name);
        $this->content = $content;
        $this->uploadKey = $uploadKey;
        $this->status = $status;
        $this->mediaType = $mediaType;
    }

    public function name(): Name
    {
        return $this->name;
    }

    public function content(): Readable
    {
        return $this->content;
    }

    public function uploadKey(): string
    {
        return $this->uploadKey;
    }

    public function status(): Status
    {
        return $this->status;
    }

    public function mediaType(): MediaType
    {
        return $this->mediaType;
    }
}
