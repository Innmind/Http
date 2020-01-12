<?php
declare(strict_types = 1);

namespace Innmind\Http\Factory\Header;

use Innmind\Http\Factory\HeaderFactory as HeaderFactoryInterface;
use Innmind\Immutable\Map;

final class Factories
{
    private static ?Map $all = null;
    private static ?HeaderFactoryInterface $default = null;

    /**
     * @return Map<string, HeaderFactoryInterface>
     */
    public static function all(): Map
    {
        return self::$all ?? self::$all = Map::of('string', HeaderFactoryInterface::class)
            ('accept-charset', new AcceptCharsetFactory)
            ('accept-encoding', new AcceptEncodingFactory)
            ('accept', new AcceptFactory)
            ('accept-language', new AcceptLanguageFactory)
            ('accept-ranges', new AcceptRangesFactory)
            ('age', new AgeFactory)
            ('allow', new AllowFactory)
            ('authorization', new AuthorizationFactory)
            ('cache-control', new CacheControlFactory)
            ('content-encoding', new ContentEncodingFactory)
            ('content-language', new ContentLanguageFactory)
            ('content-length', new ContentLengthFactory)
            ('content-location', new ContentLocationFactory)
            ('content-range', new ContentRangeFactory)
            ('content-type', new ContentTypeFactory)
            ('date', new DateFactory)
            ('expires', new ExpiresFactory)
            ('host', new HostFactory)
            ('if-modified-since', new IfModifiedSinceFactory)
            ('if-unmodified-since', new IfUnmodifiedSinceFactory)
            ('last-modified', new LastModifiedFactory)
            ('link', new LinkFactory)
            ('location', new LocationFactory)
            ('range', new RangeFactory)
            ('referer', new ReferrerFactory)
            ('cookie', new CookieFactory);
    }

    public static function default(): HeaderFactoryInterface
    {
        return self::$default ?? self::$default = new TryFactory(
            new DelegationFactory(self::all()),
            new HeaderFactory,
        );
    }
}
