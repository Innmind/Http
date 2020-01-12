<?php
declare(strict_types = 1);

namespace Innmind\Http\Factory\Header;

use Innmind\Http\Factory\HeaderFactory as HeaderFactoryInterface;
use Innmind\Immutable\{
    MapInterface,
    Map
};

final class Factories
{
    private static ?MapInterface $all = null;
    private static ?HeaderFactoryInterface $default = null;

    /**
     * @return MapInterface<string, HeaderFactoryInterface>
     */
    public static function all(): MapInterface
    {
        if (self::$all === null) {
            self::$all = (new Map('string', HeaderFactoryInterface::class))
                ->put('accept-charset', new AcceptCharsetFactory)
                ->put('accept-encoding', new AcceptEncodingFactory)
                ->put('accept', new AcceptFactory)
                ->put('accept-language', new AcceptLanguageFactory)
                ->put('accept-ranges', new AcceptRangesFactory)
                ->put('age', new AgeFactory)
                ->put('allow', new AllowFactory)
                ->put('authorization', new AuthorizationFactory)
                ->put('cache-control', new CacheControlFactory)
                ->put('content-encoding', new ContentEncodingFactory)
                ->put('content-language', new ContentLanguageFactory)
                ->put('content-length', new ContentLengthFactory)
                ->put('content-location', new ContentLocationFactory)
                ->put('content-range', new ContentRangeFactory)
                ->put('content-type', new ContentTypeFactory)
                ->put('date', new DateFactory)
                ->put('expires', new ExpiresFactory)
                ->put('host', new HostFactory)
                ->put('if-modified-since', new IfModifiedSinceFactory)
                ->put('if-unmodified-since', new IfUnmodifiedSinceFactory)
                ->put('last-modified', new LastModifiedFactory)
                ->put('link', new LinkFactory)
                ->put('location', new LocationFactory)
                ->put('range', new RangeFactory)
                ->put('referer', new ReferrerFactory)
                ->put('cookie', new CookieFactory);
        }

        return self::$all;
    }

    public static function default(): HeaderFactoryInterface
    {
        if (self::$default === null) {
            self::$default = new TryFactory(
                new DelegationFactory(self::all()),
                new HeaderFactory
            );
        }

        return self::$default;
    }
}
