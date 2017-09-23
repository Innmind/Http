<?php
declare(strict_types = 1);

namespace Innmind\Http;

use Innmind\Http\Header;

interface Headers extends \Iterator, \Countable
{
    /**
     * @param string $name Case insensitive
     *
     * @throws HeaderNotFoundException
     *
     * @return Header
     */
    public function get(string $name): Header;

    /**
     * Check if the header is present
     *
     * @param string $name Case insensitive
     *
     * @return bool
     */
    public function has(string $name): bool;
}
