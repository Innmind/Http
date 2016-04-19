<?php
declare(strict_types = 1);

namespace Innmind\Http\Message;

use Innmind\Http\File\FileInterface;

interface FilesInterface extends \Traversable, \Countable
{
    /**
     * @param string $name
     *
     * @throws FileNotFoundException
     *
     * @return FileInterface
     */
    public function get(string $name): FileInterface;

    /**
     * @param string $name
     *
     * @return bool
     */
    public function has(string $name): bool;
}
