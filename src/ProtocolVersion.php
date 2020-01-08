<?php
declare(strict_types = 1);

namespace Innmind\Http;

final class ProtocolVersion
{
    private $major;
    private $minor;

    public function __construct(int $major, int $minor)
    {
        $this->major = $major;
        $this->minor = $minor;
    }

    public function major(): int
    {
        return $this->major;
    }

    public function minor(): int
    {
        return $this->minor;
    }

    public function __toString(): string
    {
        return $this->major.'.'.$this->minor;
    }
}
