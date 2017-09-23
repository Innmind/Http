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
    private $name;
    private $content;
    private $status;
    private $mediaType;

    public function __construct(
        string $name,
        Readable $content,
        Status $status,
        MediaType $mediaType
    ) {
        $this->name = new Name\Name($name);
        $this->content = $content;
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

    public function status(): Status
    {
        return $this->status;
    }

    public function mediaType(): MediaType
    {
        return $this->mediaType;
    }
}
