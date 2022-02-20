<?php
declare(strict_types = 1);

namespace Innmind\Http\Message\StatusCode;

enum Range
{
    case informational;
    case successful;
    case redirection;
    case clientError;
    case serverError;
}
