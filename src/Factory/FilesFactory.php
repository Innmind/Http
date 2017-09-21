<?php
declare(strict_types = 1);

namespace Innmind\Http\Factory;

use Innmind\Http\Message\Files;

interface FilesFactory
{
    public function make(): Files;
}
