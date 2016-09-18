<?php
declare(strict_types = 1);

namespace Innmind\Http\Message;

interface ServerRequestInterface extends RequestInterface
{
    public function environment(): EnvironmentInterface;
    public function cookies(): CookiesInterface;
    public function query(): QueryInterface;
    public function form(): FormInterface;
    public function files(): FilesInterface;
}
