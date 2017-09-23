# Http

| `master` | `develop` |
|----------|-----------|
| [![Scrutinizer Code Quality](https://scrutinizer-ci.com/g/Innmind/Http/badges/quality-score.png?b=master)](https://scrutinizer-ci.com/g/Innmind/Http/?branch=master) | [![Scrutinizer Code Quality](https://scrutinizer-ci.com/g/Innmind/Http/badges/quality-score.png?b=develop)](https://scrutinizer-ci.com/g/Innmind/Http/?branch=develop) |
| [![Code Coverage](https://scrutinizer-ci.com/g/Innmind/Http/badges/coverage.png?b=master)](https://scrutinizer-ci.com/g/Innmind/Http/?branch=master) | [![Code Coverage](https://scrutinizer-ci.com/g/Innmind/Http/badges/coverage.png?b=develop)](https://scrutinizer-ci.com/g/Innmind/Http/?branch=develop) |
| [![Build Status](https://scrutinizer-ci.com/g/Innmind/Http/badges/build.png?b=master)](https://scrutinizer-ci.com/g/Innmind/Http/build-status/master) | [![Build Status](https://scrutinizer-ci.com/g/Innmind/Http/badges/build.png?b=develop)](https://scrutinizer-ci.com/g/Innmind/Http/build-status/develop) |

Value objects and interfaces to abstract http messages (because [PSR7](https://github.com/php-fig/http-message) didn't go far enough).

## Build a `ServerRequest`

```php
use Innmind\Http\Factory\ServerRequestFactory;

$request = ServerRequestFactory::default()->make();
```

## Send a `Response`

```php
use Innmind\Http\{
    Message\Response\Response,
    Message\StatusCode\StatusCode,
    Message\ReasonPhrase\ReasonPhrase,
    ProtocolVersion\ProtocolVersion,
    Headers\Headers,
    Header,
    Header\ContentType,
    Header\ContentTypeValue,
    ResponseSender
};
use Innmind\Filesystem\Stream\StringStream;
use Innmind\Immutable\Map;

$response = new Response(
    new StatusCode(200),
    new ReasonPhrase(ReasonPhrase::defaults()->get(200)),
    new ProtocolVersion(1, 1),
    new Headers(
        (new Map('string', Header::class))
            ->put(
                'content-type',
                new ContentType(
                    new ContentTypeValue(
                        'application',
                        'json'
                    )
                )
            )
    ),
    new StringStream('{"some": "data"}')
);

(new ResponseSender)->send($response);
```

will build the following message:

```
HTTP/1.1 200 OK
Date: Wed, 04 May 2016 14:24:14 +0000
Content-Type : application/json

{"some": "data"}
```
