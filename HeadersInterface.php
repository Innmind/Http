<?php
declare(strict_types = 1);

namespace Innmind\Http;

use Innmind\Http\Header\HeaderInterface;

interface HeadersInterface extends \Traversable, \Countable
{
    /**
     * @param string $name Case insensitive
     *
     * @throws HeaderNotFoundException
     *
     * @return HeaderInterface
     */
    public function get(string $name): HeaderInterface;

    /**
     * Check if the header is present
     *
     * @param string $name Case insensitive
     *
     * @return bool
     */
    public function has(string $name): bool;
}
