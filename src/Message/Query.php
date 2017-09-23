<?php
declare(strict_types = 1);

namespace Innmind\Http\Message;

use Innmind\Http\Message\Query\Parameter;

interface Query extends \Iterator, \Countable
{
    /**
     * @param string $name
     *
     * @throws QueryParameterFoundException
     *
     * @return Parameter
     */
    public function get(string $name): Parameter;

    /**
     * @param string $name
     *
     * @return bool
     */
    public function has(string $name): bool;
}
