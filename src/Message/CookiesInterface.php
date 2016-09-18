<?php
declare(strict_types = 1);

namespace Innmind\Http\Message;

interface CookiesInterface extends \Iterator, \Countable
{
    /**
     * @param string $name
     *
     * @throws CookieNotFoundException
     *
     * @return mixed
     */
    public function get(string $name);

    /**
     * @param string $name
     *
     * @return bool
     */
    public function has(string $name): bool;
}
