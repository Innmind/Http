<?php
declare(strict_types = 1);

namespace Innmind\Http\Message;

use Innmind\Http\Message\Form\ParameterInterface;

interface FormInterface extends \Iterator, \Countable
{
    /**
     * @param scalar $key
     *
     * @throws FormParameterNotFoundException
     *
     * @return ParameterInterface
     */
    public function get($key): ParameterInterface;

    /**
     * @param scalar $key
     *
     * @return bool
     */
    public function has($key): bool;
}
