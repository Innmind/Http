# Changelog

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
