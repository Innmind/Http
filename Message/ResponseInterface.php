<?php
declare(strict_types = 1);

namespace Innmind\Http\Message;

use Innmind\Http\MessageInterface;

interface ResponseInterface extends MessageInterface
{
    public function statusCode(): StatusCodeInterface;
    public function reasonPhrase(): ReasonPhraseInterface;
}
