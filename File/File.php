<?php
declare(strict_types = 1);

namespace Innmind\Http\File;

use Innmind\Filesystem\{
    StreamInterface,
    NameInterface,
    Name,
    MediaTypeInterface
};

final class File implements FileInterface
{
    private $name;
    private $content;
    private $status;
    private $mediaType;

    public function __construct(
        string $name,
        StreamInterface $content,
        StatusInterface $status,
        MediaTypeInterface $mediaType
    ) {
        $this->name = new Name($name);
        $this->content = $content;
        $this->status = $status;
        $this->mediaType = $mediaType;
    }

    public function name(): NameInterface
    {
        return $this->name;
    }

    public function content(): StreamInterface
    {
        return $this->content;
    }

    public function status(): StatusInterface
    {
        return $this->status;
    }

    public function clientMediaType(): MediaTypeInterface
    {
        return $this->mediaType;
    }
}
