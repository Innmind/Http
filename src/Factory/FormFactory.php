<?php
declare(strict_types = 1);

namespace Innmind\Http\Factory;

use Innmind\Http\Message\Form;

/**
 * @psalm-immutable
 */
interface FormFactory
{
    public function __invoke(): Form;
}
