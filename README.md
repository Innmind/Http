# Http

[![Build Status](https://github.com/innmind/http/workflows/CI/badge.svg?branch=master)](https://github.com/innmind/http/actions?query=workflow%3ACI)
[![codecov](https://codecov.io/gh/innmind/http/branch/develop/graph/badge.svg)](https://codecov.io/gh/innmind/http)
[![Type Coverage](https://shepherd.dev/github/innmind/http/coverage.svg)](https://shepherd.dev/github/innmind/http)

Immutable value objects and interfaces to abstract http messages.

**Important**: you must use [`vimeo/psalm`](https://packagist.org/packages/vimeo/psalm) to make sure you use this library correctly.

## Build a `ServerRequest`

```php
use Innmind\Http\Factory\ServerRequest\ServerRequestFactory;

$request = ServerRequestFactory::default()();
```

## Send a `Response`

```php
use Innmind\Http\{
    Response,
    Response\StatusCode,
    ProtocolVersion,
    Headers,
    Header,
    Header\ContentType,
    Header\ContentTypeValue,
    ResponseSender,
};
use Innmind\Filesystem\File\Content;
use Innmind\TimeContinuum\Earth\Clock;

$response = Response::of(
    StatusCode::ok,
    ProtocolVersion::v11,
    Headers::of(
        ContentType::of('application', 'json'),
    ),
    Content\Lines::ofContent('{"some": "data"}'),
);

(new ResponseSender(new Clock))($response);
```

will build the following message:

```
HTTP/1.1 200 OK
Date: Wed, 04 May 2016 14:24:14 +0000
Content-Type : application/json

{"some": "data"}
```

## Build a multipart `Request`

```php
use Innmind\Http\{
    Request,
    Method,
    Content\Multipart,
    Header\ContentType\Boundary,
    Headers,
    ProtocolVersion,
};
use Innmind\Filesystem\{
    File\File,
    File\Content,
};
use Innmind\Url\Url;

$boundary = Boundary::uuid();
$request = Request::of(
    Url::of('http://some-server.com/')
    Method::post,
    ProtocolVersion::v11,
    Headers::of($boundary->toHeader()),
    Multipart::boundary($boundary)
        ->with('some[key]', 'some value')
        ->withFile('some[file]', File::named(
            'whatever.txt',
            Content::ofString(' can be any file content'),
        )),
);
```
