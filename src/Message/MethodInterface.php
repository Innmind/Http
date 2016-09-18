<?php
declare(strict_types = 1);

namespace Innmind\Http\Message;

interface MethodInterface
{
    const GET = 'GET';
    const POST = 'POST';
    const PUT = 'PUT';
    const PATCH = 'PATCH';
    const DELETE = 'DELETE';
    const OPTIONS = 'OPTIONS';
    const TRACE = 'TRACE';
    const CONNECT = 'CONNECT';
    const HEAD = 'HEAD';
    const LINK = 'LINK';
    const UNLINK = 'UNLINK';

    public function __toString(): string;
}
