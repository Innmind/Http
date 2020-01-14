# Http

| `develop` |
|-----------|
| [![codecov](https://codecov.io/gh/Innmind/Http/branch/develop/graph/badge.svg)](https://codecov.io/gh/Innmind/Http) |
| [![Build Status](https://github.com/Innmind/Http/workflows/CI/badge.svg)](https://github.com/Innmind/Http/actions?query=workflow%3ACI) |

Value objects and interfaces to abstract http messages (because [PSR7](https://github.com/php-fig/http-message) didn't go far enough).

## Build a `ServerRequest`

```php
use Innmind\Http\Factory\ServerRequest\ServerRequestFactory;

$request = ServerRequestFactory::default()();
```

## Send a `Response`

```php
use Innmind\Http\{
    Message\Response\Response,
    Message\StatusCode,
    Message\ReasonPhrase,
    ProtocolVersion,
    Headers,
    Header,
    Header\ContentType,
    Header\ContentTypeValue,
    ResponseSender,
};
use Innmind\Stream\Readable\Stream;

$response = new Response(
    $code = StatusCode::of('OK'),
    $code->associatedReasonPhrase(),
    new ProtocolVersion(1, 1),
    Headers::of(
        new ContentType(
            new ContentTypeValue(
                'application',
                'json',
            ),
        ),
    ),
    Stream::ofContent('{"some": "data"}'),
);

(new ResponseSender)($response);
```

will build the following message:

```
HTTP/1.1 200 OK
Date: Wed, 04 May 2016 14:24:14 +0000
Content-Type : application/json

{"some": "data"}
```
