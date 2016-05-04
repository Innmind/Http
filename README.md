# Http

| `master` | `develop` |
|----------|-----------|
| [![Scrutinizer Code Quality](https://scrutinizer-ci.com/g/Innmind/Http/badges/quality-score.png?b=master)](https://scrutinizer-ci.com/g/Innmind/Http/?branch=master) | [![Scrutinizer Code Quality](https://scrutinizer-ci.com/g/Innmind/Http/badges/quality-score.png?b=develop)](https://scrutinizer-ci.com/g/Innmind/Http/?branch=develop) |
| [![Code Coverage](https://scrutinizer-ci.com/g/Innmind/Http/badges/coverage.png?b=master)](https://scrutinizer-ci.com/g/Innmind/Http/?branch=master) | [![Code Coverage](https://scrutinizer-ci.com/g/Innmind/Http/badges/coverage.png?b=develop)](https://scrutinizer-ci.com/g/Innmind/Http/?branch=develop) |
| [![Build Status](https://scrutinizer-ci.com/g/Innmind/Http/badges/build.png?b=master)](https://scrutinizer-ci.com/g/Innmind/Http/build-status/master) | [![Build Status](https://scrutinizer-ci.com/g/Innmind/Http/badges/build.png?b=develop)](https://scrutinizer-ci.com/g/Innmind/Http/build-status/develop) |

[![SensioLabsInsight](https://insight.sensiolabs.com/projects/6e2eda7e-ecd1-47d8-8b75-e2fcfaa52b7c/big.png)](https://insight.sensiolabs.com/projects/6e2eda7e-ecd1-47d8-8b75-e2fcfaa52b7c)

Value objects and interfaces to abstract http messages (because [PSR7](https://github.com/php-fig/http-message) didn't go far enough).

## Build a `ServerRequest`

```php
use Innmind\Http\Factory\ServerRequestFactory;

$request = ServerRequestFactory::default()->make();
```

## Send a `Response`

```php
use Innmind\Http\{
    Message\Response,
    Message\StatusCode,
    Message\ReasonPhrase,
    ProtocolVersion,
    Headers,
    Header\HeaderInterface,
    Header\ContentType,
    Header\ContentTypeValue,
    Header\ParameterInterface,
    ResponseSender
};
use Innmind\Filesystem\Stream\StringStream;
use Innmind\Immutable\Map;

$response = new Response(
    new StatusCode(200),
    new ReasonPhrase(ReasonPhrase::defaults()->get(200)),
    new ProtocolVersion(1, 1),
    new Headers(
        (new Map('string', HeaderInterface::class))
            ->put(
                'content-type',
                new ContentType(
                    new ContentTypeValue(
                        'application',
                        'json',
                        new Map('string', ParameterInterface::class)
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
