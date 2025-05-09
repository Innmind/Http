# Changelog

## 8.0.0 - 2025-04-20

### Added

- `Innmind\Http\Header\Custom`
- `Innmind\Http\Header\Accept\MediaType`
- `Innmind\Http\Header\Accept\Charset`
- `Innmind\Http\Header\Accept\Encoding`
- `Innmind\Http\Header\Accept\Language`
- `Innmind\Http\Header\Content\Language`
- `Innmind\Http\Header\Link\Relationship`
- `Innmind\Http\Header\WWWAuthenticate\Challenge`
- `Innmind\Http\Header\CacheControl\Directive`
- `Innmind\Http\Header\CacheControl\MaxAge`
- `Innmind\Http\Header\CacheControl\MaxStale`
- `Innmind\Http\Header\CacheControl\MinimumFresh`
- `Innmind\Http\Header\CacheControl\NoCache`
- `Innmind\Http\Header\CacheControl\PrivateCache`
- `Innmind\Http\Header\CacheControl\SharedMaxAge`
- `Innmind\Http\Header\SetCookie\Directive`
- `Innmind\Http\Header\SetCookie\Domain`
- `Innmind\Http\Header\SetCookie\Expires`
- `Innmind\Http\Header\SetCookie\MaxAge`
- `Innmind\Http\Header\SetCookie\Path`
- `Innmind\Http\Header\ContentType\Boundary::toHeader()`

### Changed

- Requires `innmind/filesystem:~8.0`
- Requires `innmind/time-continuum:~4.1`
- Requires `innmind/io:~3.0`
- `Innmind\Http\Sender::__invoke()` now returns `Innmind\Immutable\Attempt<Innmind\Immutable\SideEffect>`
- `Innmind\Http\Factory\CookiesFactory` is now a final class
- `Innmind\Http\Factory\EnvironmentFactory` is now a final class
- `Innmind\Http\Factory\FilesFactory` is now a final class
- `Innmind\Http\Factory\FormFactory` is now a final class
- `Innmind\Http\Factory\QueryFactory` is now a final class
- `Innmind\Http\Factory\ServerRequestFactory` is now a final class
- `Innmind\Http\Factory\HeadersFactory` is now a final class
- Classes in `Innmind\Http\Factory\Header\` are now internal
- `Innmind\Http\Header::values()` now returns an `Innmind\Immutable\Sequence` to allow for ordered values
- `Innmind\Http\Header\AcceptRanges` constructor is now private, use `::of()` or `::maybe()` named constructors
- `Innmind\Http\Header\Age` constructor is now private, use `::of()` or `::maybe()` named constructors
- `Innmind\Http\Header\Authorization` constructor is now private, use `::of()` or `::maybe()` named constructors
- `Innmind\Http\Header\ContentEncoding` constructor is now private, use `::of()` or `::maybe()` named constructors
- `Innmind\Http\Header\ContentLength` constructor is now private, use `::of()` or `::maybe()` named constructors
- `Innmind\Http\Header\ContentLocation` constructor is now private, use `::of()` named constructor
- `Innmind\Http\Header\ContentRange` constructor is now private, use `::of()` or `::maybe()` named constructors
- `Innmind\Http\Header\ContentType` constructor is now private, use `::of()` named constructor
- `Innmind\Http\Header\Date` constructor is now private, use `::of()` named constructor
- `Innmind\Http\Header\Expires` constructor is now private, use `::of()` named constructor
- `Innmind\Http\Header\Host` constructor is now private, use `::of()` named constructor
- `Innmind\Http\Header\IfModifiedSince` constructor is now private, use `::of()` named constructor
- `Innmind\Http\Header\IfUnmodifiedSince` constructor is now private, use `::of()` named constructor
- `Innmind\Http\Header\LastModified` constructor is now private, use `::of()` named constructor
- `Innmind\Http\Header\Location` constructor is now private, use `::of()` named constructor
- `Innmind\Http\Header\Range` constructor is now private, use `::of()` or `::maybe()` named constructors
- `Innmind\Http\Header\Referrer` constructor is now private, use `::of()` named constructor
- All custom headers now implements `Innmind\Http\Header\Custom`
- `Innmind\Http\Header` is now a final class
- `Innmind\Http\Header\Value` is now a final class
- `Innmind\Http\Header\Accept` constructor is now private, use `::of()` named constructor
- `Innmind\Http\Header\AcceptCharset` constructor is now private, use `::of()` named constructor
- `Innmind\Http\Header\AcceptEncoding` constructor is now private, use `::of()` named constructor
- `Innmind\Http\Header\Allow` constructor is now private, use `::of()` named constructor
- `Innmind\Http\Header\Allow::of()` now expects `Innmind\Http\Method` values
- `Innmind\Http\Header\ContentLanguage` constructor is now private, use `::of()` named constructor
- `Innmind\Http\Header\Link` constructor is now private, use `::of()` named constructor
- `Innmind\Http\Header\WWWAuthenticate` constructor is now private, use `::of()` named constructor
- `Innmind\Http\Header\CacheControl` constructor is now private, use `::of()` named constructor
- `Innmind\Http\Header\Cookie` constructor is now private, use `::of()` named constructor
- `Innmind\Http\Header\SetCookie` constructor is now private, use `::of()` named constructor
- `Innmind\Http\Header\Parameter\Quality` constructor is now private, use `::of()` named constructor
- `Innmind\Http\Header\Parameter\Quality` no longer implements `Innmind\Http\Header\Parameter`
- `Innmind\Http\Header\Parameter\Quality::of()` now returns `self`
- `Innmind\Http\Header\ContentType\Boundary` no longer implements `Innmind\Http\Header\Parameter`
- `Innmind\Http\Header\Parameter` is now a final class
- `Innmind\Http\Header` constructor is now private, use `::of` named constructor
- `Innmind\Http\Header\Value` constructor is now private, use `::of` named constructor
- `Innmind\Http\Header\Parameter` constructor is now private, use `::of` named constructor
- `Innmind\Http\Sender` as been moved to `Innmind\Http\Response\Sender`
- `Innmind\Http\ResponseSender` as been moved to `Innmind\Http\Response\Sender\Native`
- `Innmind\Http\Response\Sender\Native` constructor is now private, use `::of()` named constructor

### Removed

- `Innmind\Http\Factory\Cookies\CookiesFactory`
- `Innmind\Http\Factory\Environment\EnvironmentFactory`
- `Innmind\Http\Factory\Files\FilesFactory`
- `Innmind\Http\Factory\Form\FormFactory`
- `Innmind\Http\Factory\Query\QueryFactory`
- `Innmind\Http\Factory\ServerRequest\ServerRequestFactory`
- `Innmind\Http\Factory\Header\HeadersFactory`
- `Innmind\Http\Factory\HeaderFactory`
- `Innmind\Http\Header\AcceptRangesValue`
- `Innmind\Http\Header\AgeValue`
- `Innmind\Http\Header\AuthorizationValue`
- `Innmind\Http\Header\ContentEncodingValue`
- `Innmind\Http\Header\ContentLengthValue`
- `Innmind\Http\Header\ContentRangeValue`
- `Innmind\Http\Header\ContentTypeValue`
- `Innmind\Http\Header\HostValue`
- `Innmind\Http\Header\DateValue`
- `Innmind\Http\Header\LocationValue`
- `Innmind\Http\Header\RangeValue`
- `Innmind\Http\Header\ReferrerValue`
- `Innmind\Http\Header\AcceptValue`
- `Innmind\Http\Header\AcceptCharsetValue`
- `Innmind\Http\Header\AcceptEncodingValue`
- `Innmind\Http\Header\AcceptLanguageValue`
- `Innmind\Http\Header\AllowValue`
- `Innmind\Http\Header\ContentLanguageValue`
- `Innmind\Http\Header\LinkValue`
- `Innmind\Http\Header\WWWAuthenticateValue`
- `Innmind\Http\Header\CacheControlValue`
- `Innmind\Http\Header\CacheControlValue\MaxAge`
- `Innmind\Http\Header\CacheControlValue\MaxStale`
- `Innmind\Http\Header\CacheControlValue\MinimumFresh`
- `Innmind\Http\Header\CacheControlValue\NoCache`
- `Innmind\Http\Header\CacheControlValue\PrivateCache`
- `Innmind\Http\Header\CacheControlValue\SharedMaxAge`
- `Innmind\Http\Header\CookieValue`
- `Innmind\Http\Header\CookieParameter\Domain`
- `Innmind\Http\Header\CookieParameter\Expires`
- `Innmind\Http\Header\CookieParameter\HttpOnly`
- `Innmind\Http\Header\CookieParameter\MaxAge`
- `Innmind\Http\Header\CookieParameter\Path`
- `Innmind\Http\Header\CookieParameter\SameSite`
- `Innmind\Http\Header\CookieParameter\Secure`
- `Innmind\Http\Header\Parameter\NullParameter`

### Fixed

- PHP `8.4` deprecations

## 7.1.0 - 2024-06-27

### Changed

- Requires `innmind/immutable:~5.7`
- Derive bodies laziness from source bodies

## 7.0.1 - 2024-03-27

### Fixed

- Files used in `Innmind\Http\Content\Multipart` are no longer loaded in memory

## 7.0.0 - 2023-10-22

### Changed

- Requires `innmind/filesystem:~7.0`
- `Innmind\Http\Content\Multipart` now longer implements `Innmind\Filesystem\File\Content`, use `->asContent()`
- `Innmind\Http\Message\Response\Response` as been moved to `Innmind\Http\Response`
- `Innmind\Http\Message\Request\Request` as been moved to `Innmind\Http\Request`
- `Innmind\Http\Message\ServerRequest\ServerRequest` as been moved to `Innmind\Http\ServerRequest`
- `Innmind\Http\Message\Request\Stringable` has be called like this now `Stringable::new()($request)`
- `Innmind\Http\Message\Response\Stringable` has be called like this now `Stringable::new()($request)`
- `Innmind\Http\Message\ServerRequest\Stringable` has be called like this now `Stringable::new()($request)`
- `Innmind\Http\Message\Request\Stringable` has been moved to `Innmind\Http\Request\Stringable`
- `Innmind\Http\Message\Response\Stringable` has been moved to `Innmind\Http\Response\Stringable`
- `Innmind\Http\Message\ServerRequest\Stringable` has been moved to `Innmind\Http\ServerRequest\Stringable`
- `Innmind\Http\Message\StatusCode` has been moved to `Innmind\Http\Response\StatusCode`
- `Innmind\Http\Message\StatusCode\Range` has been moved to `Innmind\Http\Response\StatusCode\Range`
- `Innmind\Http\Message\Method` has been moved to `Innmind\Http\Method`
- `Innmind\Http\Message\Cookies` has been moved to `Innmind\Http\ServerRequest\Cookies`
- `Innmind\Http\Message\Environment` has been moved to `Innmind\Http\ServerRequest\Environment`
- `Innmind\Http\Message\Files` has been moved to `Innmind\Http\ServerRequest\Files`
- `Innmind\Http\Message\Form` has been moved to `Innmind\Http\ServerRequest\Form`
- `Innmind\Http\Message\Query` has been moved to `Innmind\Http\ServerRequest\Query`
- `Innmind\Http\Request` constructor is now private, use `::of()` named constructor instead
- `Innmind\Http\ServerRequest` constructor is now private, use `::of()` named constructor instead
- `Innmind\Http\Response` constructor is now private, use `::of()` named constructor instead
- `Innmind\Http\ServerRequest\Cookies` constructor is now private, use `::of()` named constructor instead
- `Innmind\Http\ServerRequest\Environment` constructor is now private, use `::of()` named constructor instead

### Removed

- `Innmind\Http\File\Input`
- `Innmind\Http\Message\Response`
- `Innmind\Http\Message\Request`
- `Innmind\Http\Message\ServerRequest`
- `Innmind\Http\Message`

## 6.4.0 - 2023-09-16

### Added

- Support for `innmind/immutable:~5.0`

### Removed

- Support for PHP `8.1`

## 6.3.0 - 2023-04-30

### Added

- `Innmind\Http\Headers::all()`
- `Innmind\Http\Message\Request\Stringable::asContent()`
- `Innmind\Http\Message\Response\Stringable::asContent()`
- `Innmind\Http\Message\ServerRequest\Stringable::asContent()`

### Changed

- `Innmind\Http\Headers` now keeps the order in which headers are added

## 6.2.0 - 2023-04-02

### Added

- `Innmind\Http\Headers::filter()`
- `Innmind\Http\Message\Method::safe()` and `::idempotent()`
- `Innmind\Http\Header\ContentType\Boundary`
- `Innmind\Http\Content\Multipart`

## 6.1.0 - 2023-02-17

### Added

- `Innmind\Http\Header\Age::age()`
- `Innmind\Http\Header\AgeValue::age()`
- `Innmind\Http\Header\Authorization::scheme()`
- `Innmind\Http\Header\Authorization::parameter()`
- `Innmind\Http\Header\ContentLength::length()`
- `Innmind\Http\Header\ContentLengthValue::length()`
- `Innmind\Http\Header\ContentLocation::url()`
- `Innmind\Http\Header\ContentRange::range()`
- `Innmind\Http\Header\ContentType::content()`
- `Innmind\Http\Header\Cookie::parameters()`
- `Innmind\Http\Header\Date::date()`
- `Innmind\Http\Header\DateValue::date()`
- `Innmind\Http\Header\Expires::date()`
- `Innmind\Http\Header\Host::host()`
- `Innmind\Http\Header\Host::port()`
- `Innmind\Http\Header\IfModifiedSince::date()`
- `Innmind\Http\Header\IfUnmodifiedSince::date()`
- `Innmind\Http\Header\LastModified::date()`
- `Innmind\Http\Header\Range::range()`
- `Innmind\Http\Header\Referrer::referrer()`
- `Innmind\Http\Header\ReferrerValue::url()`

## 6.0.1 - 2023-02-12

### Fixed

- Parsing `Content-Type` headers like `application/x-www-form-urlencoded` by reusing the `innmind/media-type` abstraction

## 6.0.0 - 2023-01-29

### Added

- `Innmind\Http\Factory\ServerRequest\ServerRequestFactory::default()` now accepts `Innmind\Stream\Capabilities` as second argument

### Changed

- `Innmind\Http\Header\Authorization` string representation no longer encapsulate the realm with `"`

## 5.3.1 - 2022-12-18

### Added

- `Innmind\Http\File\Input`

### Fixed

- `Innmind\Http\Factory\ServerRequest\ServerRequestFactory` now uses the new `Input` as request body as the resource can't be rewinded

## 5.3.0 - 2022-12-18

### Added

- Support for `innmind/filesystem:~6.0`

## 5.2.0 - 2022-03-13

### Added

- `Innmind\Http\Header\Location::url()`

## 5.1.0 - 2022-03-12

### Added

- `Innmind\Http\Message\StatusCode::maybe()`
