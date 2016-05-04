<?php
declare(strict_types = 1);

namespace Innmind\Http\Message;

use Innmind\Http\Message\Query\ParameterInterface;

interface QueryInterface extends \Iterator, \Countable
{
    /**
     * @param string $name
     *
     * @throws QueryParameterFoundException
     *
     * @return ParameterInterface
     */
    public function get(string $name): ParameterInterface;

    /**
     * @param string $name
     *
     * @return bool
     */
    public function has(string $name): bool;
}
