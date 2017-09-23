<?php
declare(strict_types = 1);

namespace Innmind\Http\Message;

use Innmind\Http\File;

interface Files extends \Iterator, \Countable
{
    /**
     * @param string $name
     *
     * @throws FileNotFoundException
     *
     * @return File
     */
    public function get(string $name): File;

    /**
     * @param string $name
     *
     * @return bool
     */
    public function has(string $name): bool;
}
