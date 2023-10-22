<?php
declare(strict_types = 1);

namespace Innmind\Http\Response\StatusCode;

enum Range
{
    case informational;
    case successful;
    case redirection;
    case clientError;
    case serverError;
}
