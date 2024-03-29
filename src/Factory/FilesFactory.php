<?php
declare(strict_types = 1);

namespace Innmind\Http\Factory;

use Innmind\Http\ServerRequest\Files;

/**
 * @psalm-immutable
 */
interface FilesFactory
{
    public function __invoke(): Files;
}
