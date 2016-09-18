<?php
declare(strict_types = 1);

namespace Innmind\Http\Factory;

use Innmind\Http\Message\FilesInterface;

interface FilesFactoryInterface
{
    public function make(): FilesInterface;
}
