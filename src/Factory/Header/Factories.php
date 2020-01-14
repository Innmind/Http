<?php
declare(strict_types = 1);

namespace Innmind\Http\Factory\Header;

use Innmind\Http\Factory\HeaderFactory as HeaderFactoryInterface;
use Innmind\Immutable\Map;

final class Factories
{
    /** @var Map<string, HeaderFactoryInterface>|null */
    private static ?Map $all = null;
    private static ?HeaderFactoryInterface $default = null;

    /**
     * @return Map<string, HeaderFactoryInterface>
     */
    public static function all(): Map
    {
        if (\is_null(self::$all)) {
            /** @var Map<string, HeaderFactoryInterface> */
            self::$all = Map::of('string', HeaderFactoryInterface::class)
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

        /** @var Map<string, HeaderFactoryInterface> */
        return self::$all;
    }

    public static function default(): HeaderFactoryInterface
    {
        return self::$default ?? self::$default = new TryFactory(
            new DelegationFactory(self::all()),
            new HeaderFactory,
        );
    }
}
