<?php
declare(strict_types = 1);

namespace Innmind\Http\Factory\Header;

use Innmind\TimeContinuum\Clock;
use Innmind\Immutable\Map;

/**
 * @internal
 */
final class Factories
{
    /**
     * @return Map<string, Implementation>
     */
    public static function all(Clock $clock): Map
    {
        /** @var Map<string, Implementation> */
        return Map::of(
            ['accept-charset', new AcceptCharsetFactory],
            ['accept-encoding', new AcceptEncodingFactory],
            ['accept', new AcceptFactory],
            ['accept-language', new AcceptLanguageFactory],
            ['accept-ranges', new AcceptRangesFactory],
            ['age', new AgeFactory],
            ['allow', new AllowFactory],
            ['authorization', new AuthorizationFactory],
            ['cache-control', new CacheControlFactory],
            ['content-encoding', new ContentEncodingFactory],
            ['content-language', new ContentLanguageFactory],
            ['content-length', new ContentLengthFactory],
            ['content-location', new ContentLocationFactory],
            ['content-range', new ContentRangeFactory],
            ['content-type', new ContentTypeFactory],
            ['date', new DateFactory($clock)],
            ['expires', new ExpiresFactory($clock)],
            ['host', new HostFactory],
            ['if-modified-since', new IfModifiedSinceFactory($clock)],
            ['if-unmodified-since', new IfUnmodifiedSinceFactory($clock)],
            ['last-modified', new LastModifiedFactory($clock)],
            ['link', new LinkFactory],
            ['location', new LocationFactory],
            ['range', new RangeFactory],
            ['referer', new ReferrerFactory],
            ['cookie', new CookieFactory],
        );
    }

    public static function default(Clock $clock): DelegationFactory
    {
        return new DelegationFactory(self::all($clock));
    }
}
