<?php
declare(strict_types = 1);

namespace Innmind\Http\Factory\Header;

use Innmind\Http\{
    Header,
    Header\AcceptCharset,
    Header\AcceptEncoding,
    Header\Accept,
    Header\AcceptLanguage,
    Header\AcceptRanges,
    Header\Age,
    Header\Allow,
    Header\Authorization,
    Header\CacheControl,
    Header\Content,
    Header\ContentEncoding,
    Header\ContentLanguage,
    Header\ContentLength,
    Header\ContentLocation,
    Header\ContentRange,
    Header\ContentType,
    Header\Cookie,
    Header\Date,
    Header\Expires,
    Header\Host,
    Header\IfModifiedSince,
    Header\IfUnmodifiedSince,
    Header\LastModified,
    Header\Link,
    Header\Location,
    Header\Custom,
    Header\Range,
    Header\Referrer,
    Header\Parameter,
    Header\Parameter\Quality,
    TimeContinuum\Format\Http,
    Method,
};
use Innmind\TimeContinuum\Clock;
use Innmind\Validation\Is;
use Innmind\MediaType\MediaType;
use Innmind\Url\Url;
use Innmind\Immutable\{
    Str,
    Maybe,
    Sequence,
    Map,
    Predicate,
    Predicate\Instance,
};

/**
 * @internal
 * @psalm-immutable
 */
enum Factories
{
    case acceptCharset;
    case acceptEncoding;
    case accept;
    case acceptLanguage;
    case acceptRanges;
    case age;
    case allow;
    case authorization;
    case cacheControl;
    case contentEncoding;
    case contentLanguage;
    case contentLength;
    case contentLocation;
    case contentRange;
    case contentType;
    case cookie;
    case date;
    case expires;
    case host;
    case ifModifiedSince;
    case ifUnmodifiedSince;
    case lastModified;
    case link;
    case location;
    case range;
    case referrer;

    /**
     * @psalm-pure
     */
    public static function of(Str $name): ?self
    {
        $name = $name->toLower()->toString();

        return match ($name) {
            'accept-charset' => self::acceptCharset,
            'accept-encoding' => self::acceptEncoding,
            'accept' => self::accept,
            'accept-language' => self::acceptLanguage,
            'accept-ranges' => self::acceptRanges,
            'age' => self::age,
            'allow' => self::allow,
            'authorization' => self::authorization,
            'cache-control' => self::cacheControl,
            'content-encoding' => self::contentEncoding,
            'content-language' => self::contentLanguage,
            'content-length' => self::contentLength,
            'content-location' => self::contentLocation,
            'content-range' => self::contentRange,
            'content-type' => self::contentType,
            'cookie' => self::cookie,
            'date' => self::date,
            'expires' => self::expires,
            'host' => self::host,
            'if-modified-since' => self::ifModifiedSince,
            'if-unmodified-since' => self::ifUnmodifiedSince,
            'last-modified' => self::lastModified,
            'link' => self::link,
            'location' => self::location,
            'range' => self::range,
            'referer' => self::referrer,
            default => null,
        };
    }

    /**
     * @return Maybe<Header|Custom>
     */
    public function try(Clock $clock, Str $value): Maybe
    {
        return match ($this) {
            self::acceptCharset => $value
                ->split(',')
                ->map(static function(Str $accept) {
                    $matches = $accept->capture(
                        '~(?<charset>[a-zA-Z0-9\-_:\(\)]+)(; ?q=(?<quality>\d+(\.\d+)?))?~',
                    );
                    /** @var Predicate<int<0, 100>> */
                    $range = Is::int()
                        ->range(0, 100)
                        ->asPredicate();
                    $quality = $matches
                        ->get('quality')
                        ->map(static fn($quality) => (float) $quality->toString())
                        ->map(static fn($quality) => (int) ($quality * 100.0))
                        ->otherwise(static fn() => Maybe::just(100))
                        ->keep($range)
                        ->map(Quality::of(...));
                    $charset = $matches
                        ->get('charset')
                        ->map(static fn($charset) => $charset->toString());

                    return Maybe::all($charset, $quality)->flatMap(
                        Accept\Charset::maybe(...),
                    );
                })
                ->sink(self::values(Accept\Charset::class))
                ->maybe(static fn($values, $value) => $value->map($values))
                ->map(static fn($values) => AcceptCharset::of(...$values->toList())),

            self::acceptEncoding => $value
                ->split(',')
                ->map(static function(Str $accept) {
                    $matches = $accept->capture(
                        '~(?<coding>(\w+|\*))(; ?q=(?<quality>\d+(\.\d+)?))?~',
                    );
                    /** @var Predicate<int<0, 100>> */
                    $range = Is::int()
                        ->range(0, 100)
                        ->asPredicate();
                    $quality = $matches
                        ->get('quality')
                        ->map(static fn($quality) => (float) $quality->toString())
                        ->map(static fn($quality) => (int) ($quality * 100.0))
                        ->otherwise(static fn() => Maybe::just(100))
                        ->keep($range)
                        ->map(Quality::of(...));
                    $coding = $matches
                        ->get('coding')
                        ->map(static fn($coding) => $coding->toString());

                    return Maybe::all($coding, $quality)->flatMap(
                        Accept\Encoding::maybe(...),
                    );
                })
                ->sink(self::values(Accept\Encoding::class))
                ->maybe(static fn($values, $value) => $value->map($values))
                ->map(static fn($values) => AcceptEncoding::of(...$values->toList())),

            self::accept => $value
                ->split(',')
                ->map(static function(Str $accept) {
                    $matches = $accept->capture(
                        '~(?<type>[\w*]+)/(?<subType>[\w*]+)(?<params>(; ?\w+=\"?[\w\-.]+\"?)+)?~',
                    );
                    $params = self::buildAcceptParams($matches->get('params')->match(
                        static fn($params) => $params,
                        static fn() => Str::of(''),
                    ));

                    /**
                     * @psalm-suppress MixedArgument Because $params can't be typed in the closure
                     */
                    return Maybe::all(
                        $matches->get('type'),
                        $matches->get('subType'),
                        $params,
                    )->flatMap(static fn(Str $type, Str $subType, array $params) => Accept\MediaType::maybe(
                        $type->toString(),
                        $subType->toString(),
                        ...$params,
                    ));
                })
                ->sink(self::values(Accept\MediaType::class))
                ->maybe(static fn($values, $value) => $value->map($values))
                ->map(static fn($values) => $values->match(
                    static fn($first, $rest) => Accept::of($first, ...$rest->toList()),
                    static fn() => null,
                ))
                ->keep(Instance::of(Accept::class)),

            self::acceptLanguage => $value
                ->split(',')
                ->map(static function(Str $accept) {
                    $matches = $accept->capture(
                        '~(?<lang>([a-zA-Z0-9]+(-[a-zA-Z0-9]+)*|\*))(; ?q=(?<quality>\d+(\.\d+)?))?~',
                    );
                    /** @var Predicate<int<0, 100>> */
                    $range = Is::int()
                        ->range(0, 100)
                        ->asPredicate();
                    $quality = $matches
                        ->get('quality')
                        ->map(static fn($quality) => (float) $quality->toString())
                        ->map(static fn($quality) => (int) ($quality * 100.0))
                        ->otherwise(static fn() => Maybe::just(100))
                        ->keep($range)
                        ->map(Quality::of(...));
                    $lang = $matches
                        ->get('lang')
                        ->map(static fn($lang) => $lang->toString());

                    return Maybe::all($lang, $quality)->flatMap(
                        Accept\Language::maybe(...),
                    );
                })
                ->sink(self::values(Accept\Language::class))
                ->maybe(static fn($values, $value) => $value->map($values))
                ->map(static fn($values) => AcceptLanguage::of(...$values->toList())),

            self::acceptRanges => AcceptRanges::maybe($value->toString()),

            self::age => Maybe::just($value->toString())
                ->filter(\is_numeric(...))
                ->map(static fn($age) => (int) $age)
                ->flatMap(Age::maybe(...)),

            self::allow => $value
                ->split(',')
                ->map(static fn($allow) => $allow->trim()->toUpper()->toString())
                ->map(Method::maybe(...))
                ->sink(self::values(Method::class))
                ->maybe(static fn($values, $value) => $value->map($values))
                ->map(static fn($values) => Allow::of(...$values->toList())),

            self::authorization => self::authorization($value),

            self::cacheControl => $value
                ->split(',')
                ->map(static fn($split) => $split->trim())
                ->map(static fn($split) => match (true) {
                    $split->matches('~^max-age=\d+$~') => Maybe::just($split->substring(8)->toString())
                        ->filter(\is_numeric(...))
                        ->map(static fn($age) => (int) $age)
                        ->keep(
                            Is::int()
                                ->positive()
                                ->or(Is::value(0))
                                ->asPredicate(),
                        )
                        ->map(CacheControl\MaxAge::of(...)),
                    $split->matches('~^max-stale(=\d+)?$~') => Maybe::just($split)
                        ->filter(static fn($split) => $split->length() > 10)
                        ->map(static fn($split) => $split->substring(10)->toString())
                        ->filter(\is_numeric(...))
                        ->map(static fn($age) => (int) $age)
                        ->otherwise(static fn() => Maybe::just(0))
                        ->keep(
                            Is::int()
                                ->positive()
                                ->or(Is::value(0))
                                ->asPredicate(),
                        )
                        ->map(CacheControl\MaxStale::of(...)),
                    $split->matches('~^min-fresh=\d+$~') => Maybe::just($split->substring(10)->toString())
                        ->filter(\is_numeric(...))
                        ->map(static fn($age) => (int) $age)
                        ->keep(
                            Is::int()
                                ->positive()
                                ->or(Is::value(0))
                                ->asPredicate(),
                        )
                        ->map(CacheControl\MinimumFresh::of(...)),
                    $split->toString() === 'must-revalidate' => Maybe::just(CacheControl\Directive::mustRevalidate),
                    $split->matches('~^no-cache(="?\w+"?)?$~') => $split
                        ->capture('~^no-cache(="?(?<field>\w+)"?)?$~')
                        ->get('field')
                        ->map(static fn($field) => $field->toString())
                        ->otherwise(static fn() => Maybe::just(''))
                        ->flatMap(CacheControl\NoCache::maybe(...)),
                    $split->toString() === 'no-store' => Maybe::just(CacheControl\Directive::noStore),
                    $split->toString() === 'immutable' => Maybe::just(CacheControl\Directive::immutable),
                    $split->toString() === 'no-transform' => Maybe::just(CacheControl\Directive::noTransform),
                    $split->toString() === 'only-if-cached' => Maybe::just(CacheControl\Directive::onlyIfCached),
                    $split->matches('~^private(="?\w+"?)?$~') => $split
                        ->capture('~^private(="?(?<field>\w+)"?)?$~')
                        ->get('field')
                        ->map(static fn($field) => $field->toString())
                        ->otherwise(static fn() => Maybe::just(''))
                        ->flatMap(CacheControl\PrivateCache::maybe(...)),
                    $split->toString() === 'proxy-revalidate' => Maybe::just(CacheControl\Directive::proxyRevalidate),
                    $split->toString() === 'public' => Maybe::just(CacheControl\Directive::public),
                    $split->matches('~^s-maxage=\d+$~') => Maybe::just($split->substring(9)->toString())
                        ->filter(\is_numeric(...))
                        ->map(static fn($age) => (int) $age)
                        ->keep(
                            Is::int()
                                ->positive()
                                ->or(Is::value(0))
                                ->asPredicate(),
                        )
                        ->map(CacheControl\SharedMaxAge::of(...)),
                    default => null,
                })
                ->keep(Instance::of(Maybe::class))
                // this is the wrong type but it would be too complex to express
                // the correct one, and it doesn't affect the runtime
                ->sink(self::values(CacheControl\Directive::class))
                ->maybe(static fn($values, $value) => $value->map($values))
                ->map(static fn($values) => $values->match(
                    static fn($first, $rest) => CacheControl::of($first, ...$rest->toList()),
                    static fn() => null,
                ))
                ->keep(Instance::of(CacheControl::class)),

            self::contentEncoding => ContentEncoding::maybe($value->toString()),

            self::contentLanguage => $value
                ->split(',')
                ->map(static fn($language) => $language->trim()->toString())
                ->map(Content\Language::maybe(...))
                ->sink(self::values(Content\Language::class))
                ->maybe(static fn($values, $value) => $value->map($values))
                ->map(static fn($values) => ContentLanguage::of(...$values->toList())),

            self::contentLength => Maybe::just($value->toString())
                ->filter(\is_numeric(...))
                ->map(static fn($length) => (int) $length)
                ->flatMap(ContentLength::maybe(...)),

            self::contentLocation => Url::maybe($value->toString())->map(
                ContentLocation::of(...),
            ),

            self::contentRange => self::contentRange($value->trim()),

            self::contentType => MediaType::maybe($value->toString())->map(
                ContentType::of(...),
            ),

            self::cookie => Maybe::just($value)
                ->filter(static fn($value) => $value->matches(
                    '~^(\w+=\"?[\w\-.]*\"?)?(; ?\w+=\"?[\w\-.]*\"?)*$~',
                ))
                ->flatMap(
                    static fn($value) => self::buildCookieParams($value)
                        ->sink(self::values(Parameter::class))
                        ->maybe(static fn($params, $param) => $param->map($params)),
                )
                ->map(static fn($params) => Cookie::of(...$params->toList())),

            self::date => Is::string()->nonEmpty()($value->toString())
                ->maybe()
                ->flatMap(static fn($value) => $clock->at($value, Http::new()))
                ->map(Date::of(...)),

            self::expires => Is::string()->nonEmpty()($value->toString())
                ->maybe()
                ->flatMap(static fn($value) => $clock->at($value, Http::new()))
                ->map(Expires::of(...)),

            self::host => Url::maybe('http://'.$value->toString())->map(static fn($url) => Host::of(
                $url->authority()->host(),
                $url->authority()->port(),
            )),

            self::ifModifiedSince => Is::string()->nonEmpty()($value->toString())
                ->maybe()
                ->flatMap(static fn($value) => $clock->at($value, Http::new()))
                ->map(IfModifiedSince::of(...)),

            self::ifUnmodifiedSince => Is::string()->nonEmpty()($value->toString())
                ->maybe()
                ->flatMap(static fn($value) => $clock->at($value, Http::new()))
                ->map(IfUnmodifiedSince::of(...)),

            self::lastModified => Is::string()->nonEmpty()($value->toString())
                ->maybe()
                ->flatMap(static fn($value) => $clock->at($value, Http::new()))
                ->map(LastModified::of(...)),

            self::link => $value
                ->split(',')
                ->map(static fn($link) => $link->trim())
                ->map(static function(Str $link) {
                    $matches = $link->capture(
                        '~^<(?<url>\S+)>(?<params>(; ?\w+=\"?[ \t!#$%&\\\'()*+\-.\/\d:<=>?@A-z{|}\~]+\"?)+)?$~',
                    );
                    $params = self::buildLinkParams(
                        $matches->get('params')->match(
                            static fn($params) => $params,
                            static fn() => Str::of(''),
                        ),
                    );
                    $url = $matches
                        ->get('url')
                        ->flatMap(static fn($url) => Url::maybe($url->toString()));

                    return $params->flatMap(
                        static fn($params) => $params
                            ->get('rel')
                            ->otherwise(static fn() => Maybe::just(Parameter::of(
                                'rel',
                                'related',
                            )))
                            ->map(static fn($rel) => $rel->value())
                            ->keep(Is::string()->nonEmpty()->asPredicate())
                            ->flatMap(
                                static fn($rel) => $url->map(
                                    static fn($url) => Link\Relationship::of(
                                        $url,
                                        $rel,
                                        ...$params
                                            ->remove('rel')
                                            ->values()
                                            ->toList(),
                                    ),
                                ),
                            ),
                    );
                })
                ->sink(self::values(Link\Relationship::class))
                ->maybe(static fn($values, $value) => $value->map($values))
                ->map(static fn($values) => Link::of(...$values->toList())),

            self::location => Url::maybe($value->toString())->map(
                Location::of(...),
            ),

            self::range => self::range($value),

            self::referrer => Url::maybe($value->toString())->map(
                Referrer::of(...),
            ),

            default => Maybe::nothing()->keep(Instance::of(Header::class)),
        };
    }

    /**
     * @psalm-pure
     * @template T
     *
     * @param class-string<T> $class
     *
     * @return Sequence<T>
     */
    private static function values(string $class): Sequence
    {
        /** @var Sequence<T> */
        return Sequence::of();
    }

    /**
     * @return Maybe<list<Parameter>>
     */
    private static function buildAcceptParams(Str $params): Maybe
    {
        return $params
            ->split(';')
            ->filter(static fn($value) => !$value->trim()->empty())
            ->map(static function(Str $value) {
                $matches = $value->capture('~(?<key>\w+)=\"?(?<value>[\w\-.]+)\"?~');

                return Maybe::all($matches->get('key'), $matches->get('value'))
                    ->map(static fn(Str $key, Str $value) => Parameter::of(
                        $key->toString(),
                        $value->toString(),
                    ));
            })
            ->sink(self::values(Parameter::class))
            ->maybe(static fn($params, $param) => $param->map($params))
            ->map(static fn($params) => $params->toList());
    }

    /**
     * @return Maybe<Map<string, Parameter>>
     */
    private static function buildLinkParams(Str $params): Maybe
    {
        /** @var Sequence<array{string, Parameter}> */
        $values = Sequence::of();

        return $params
            ->split(';')
            ->filter(static fn(Str $value) => !$value->trim()->empty())
            ->map(static function(Str $value) {
                $matches = $value->capture('~(?<key>\w+)=\"?(?<value>[ \t!#$%&\\\'()*+\-.\/\d:<=>?@A-z{|}\~]+)\"?~');

                return Maybe::all($matches->get('key'), $matches->get('value'))
                    ->map(static fn(Str $key, Str $value) => Parameter::of(
                        $key->toString(),
                        $value->toString(),
                    ))
                    ->map(static fn($parameter) => [$parameter->name(), $parameter]);
            })
            ->sink($values)
            ->maybe(static fn($params, $param) => $param->map($params))
            ->map(static fn($params) => Map::of(...$params->toList()));
    }

    /**
     * @return Sequence<Maybe<Parameter>>
     */
    private static function buildCookieParams(Str $params): Sequence
    {
        return $params
            ->split(';')
            ->map(static fn($value) => $value->trim())
            ->filter(static fn($value) => !$value->empty())
            ->map(static function(Str $value) {
                $matches = $value->capture('~^(?<key>\w+)=\"?(?<value>[\w\-.]*)\"?$~');

                return Maybe::all($matches->get('key'), $matches->get('value'))
                    ->map(static fn(Str $key, Str $value) => Parameter::of(
                        $key->toString(),
                        $value->toString(),
                    ));
            });
    }

    /**
     * @psalm-pure
     *
     * @return Maybe<Range>
     */
    private static function range(Str $value): Maybe
    {
        $matches = $value
            ->capture('~^(?<unit>\w+)=(?<first>\d+)-(?<last>\d+)$~')
            ->map(static fn($_, $match) => $match->toString());

        return Maybe::all(
            $matches->get('unit'),
            $matches->get('first')->filter(\is_numeric(...)),
            $matches->get('last')->filter(\is_numeric(...)),
        )
            ->flatMap(static fn(string $unit, string $first, string $last) => Range::maybe(
                $unit,
                (int) $first,
                (int) $last,
            ));
    }

    /**
     * @psalm-pure
     *
     * @return Maybe<ContentRange>
     */
    private static function contentRange(Str $value): Maybe
    {
        $matches = $value->capture(
            '~^(?<unit>\w+) (?<first>\d+)-(?<last>\d+)/(?<length>\d+|\*)$~',
        );
        $length = $matches
            ->get('length')
            ->map(static fn($length) => $length->toString())
            ->filter(static fn($length) => $length !== '*')
            ->map(static fn($length) => (int) $length)
            ->match(
                static fn($length) => $length,
                static fn() => null,
            );

        return Maybe::all($matches->get('unit'), $matches->get('first'), $matches->get('last'))
            ->flatMap(static fn(Str $unit, Str $first, Str $last) => ContentRange::maybe(
                $unit->toString(),
                (int) $first->toString(),
                (int) $last->toString(),
                $length,
            ));
    }

    /**
     * @psalm-pure
     *
     * @return Maybe<Authorization>
     */
    private static function authorization(Str $value): Maybe
    {
        $matches = $value->capture(
            '~^"?(?<scheme>\w+)"? ?(?<param>.+)?$~',
        );
        $param = $matches
            ->get('param')
            ->map(static fn($param) => $param->toString())
            ->match(
                static fn($param) => $param,
                static fn() => '',
            );

        return $matches
            ->get('scheme')
            ->map(static fn($scheme) => $scheme->toString())
            ->flatMap(static fn($scheme) => Authorization::maybe($scheme, $param));
    }
}
