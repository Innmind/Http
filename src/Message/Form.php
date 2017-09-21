<?php
declare(strict_types = 1);

namespace Innmind\Http\Message;

use Innmind\Http\Message\Form\Parameter;

interface Form extends \Iterator, \Countable
{
    /**
     * @param scalar $key
     *
     * @throws FormParameterNotFoundException
     *
     * @return Parameter
     */
    public function get($key): Parameter;

    /**
     * @param scalar $key
     *
     * @return bool
     */
    public function has($key): bool;
}
