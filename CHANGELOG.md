# Changelog

## [Unreleased]

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
