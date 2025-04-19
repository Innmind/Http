<?php
declare(strict_types = 1);

namespace Innmind\Http\Factory\Header;

use Innmind\Http\Header;
use Innmind\TimeContinuum\Clock;
use Innmind\Immutable\Str;

/**
 * @internal
 * @psalm-immutable
 */
final class Factory
{
    /** @var array<string, Implementation> */
    private array $factories;
    private HeaderFactory $fallback;

    private function __construct(Clock $clock)
    {
        $this->factories = [
            'accept-charset' => new AcceptCharsetFactory,
            'accept-encoding' => new AcceptEncodingFactory,
            'accept' => new AcceptFactory,
            'accept-language' => new AcceptLanguageFactory,
            'accept-ranges' => new AcceptRangesFactory,
            'age' => new AgeFactory,
            'allow' => new AllowFactory,
            'authorization' => new AuthorizationFactory,
            'cache-control' => new CacheControlFactory,
            'content-encoding' => new ContentEncodingFactory,
            'content-language' => new ContentLanguageFactory,
            'content-length' => new ContentLengthFactory,
            'content-location' => new ContentLocationFactory,
            'content-range' => new ContentRangeFactory,
            'content-type' => new ContentTypeFactory,
            'date' => new DateFactory($clock),
            'expires' => new ExpiresFactory($clock),
            'host' => new HostFactory,
            'if-modified-since' => new IfModifiedSinceFactory($clock),
            'if-unmodified-since' => new IfUnmodifiedSinceFactory($clock),
            'last-modified' => new LastModifiedFactory($clock),
            'link' => new LinkFactory,
            'location' => new LocationFactory,
            'range' => new RangeFactory,
            'referer' => new ReferrerFactory,
            'cookie' => new CookieFactory,
        ];
        $this->fallback = new HeaderFactory;
    }

    public function __invoke(Str $name, Str $value): Header
    {
        $normalized = $name->toLower()->toString();

        if (\array_key_exists($normalized, $this->factories)) {
            return $this->factories[$normalized]($value)->match(
                static fn($header) => $header,
                fn() => ($this->fallback)($name, $value),
            );
        }

        return ($this->fallback)($name, $value);
    }

    public static function new(Clock $clock): self
    {
        return new self($clock);
    }
}
