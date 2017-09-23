<?php
declare(strict_types = 1);

namespace Innmind\Http\Message;

interface Environment extends \Iterator, \Countable
{
    /**
     * @param string $name
     *
     * @throws EnvironmentVariableNotFoundException
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
