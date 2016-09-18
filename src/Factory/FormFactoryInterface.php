<?php
declare(strict_types = 1);

namespace Innmind\Http\Factory;

use Innmind\Http\Message\FormInterface;

interface FormFactoryInterface
{
    public function make(): FormInterface;
}
