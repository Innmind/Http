<?php
declare(strict_types = 1);

namespace Innmind\Http\Factory;

use Innmind\Http\Message\Form;

interface FormFactory
{
    public function make(): Form;
}
