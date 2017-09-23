<?php
declare(strict_types = 1);

namespace Innmind\Http\Message;

interface ServerRequest extends Request
{
    public function environment(): Environment;
    public function cookies(): Cookies;
    public function query(): Query;
    public function form(): Form;
    public function files(): Files;
}
