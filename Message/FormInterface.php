<?php
declare(strict_types = 1);

namespace Innmind\Http\Message;

use Innmind\Http\Message\Form\ParameterInterface;

interface FormInterface extends \Traversable, \Countable
{
    /**
     * @param string $name
     *
     * @throws FormParameterFoundException
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
