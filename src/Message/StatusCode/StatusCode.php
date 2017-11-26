<?php
declare(strict_types = 1);

namespace Innmind\Http\Message\StatusCode;

use Innmind\Http\{
    Message\StatusCode as StatusCodeInterface,
    Exception\DomainException
};
use Innmind\Immutable\{
    MapInterface,
    Map
};

final class StatusCode implements StatusCodeInterface
{
    private static $codes;
    private $code;

    public function __construct(int $code)
    {
        if (!self::codes()->values()->contains($code)) {
            throw new DomainException;
        }

        $this->code = $code;
    }

    public function value(): int
    {
        return $this->code;
    }

    public function __toString(): string
    {
        return (string) $this->code;
    }

    /**
     * @return MapInterface<string, int>
     */
    public static function codes(): MapInterface
    {
        if (self::$codes === null) {
            self::$codes = (new Map('string', 'int'))
                ->put('CONTINUE', 100)
                ->put('SWITCHING_PROTOCOLS', 101)
                ->put('PROCESSING', 102) // RFC2518
                ->put('OK', 200)
                ->put('CREATED', 201)
                ->put('ACCEPTED', 202)
                ->put('NON_AUTHORITATIVE_INFORMATION', 203)
                ->put('NO_CONTENT', 204)
                ->put('RESET_CONTENT', 205)
                ->put('PARTIAL_CONTENT', 206)
                ->put('MULTI_STATUS', 207) // RFC4918
                ->put('ALREADY_REPORTED', 208) // RFC5842
                ->put('IM_USED', 226) // RFC3229
                ->put('MULTIPLE_CHOICES', 300)
                ->put('MOVED_PERMANENTLY', 301)
                ->put('FOUND', 302)
                ->put('SEE_OTHER', 303)
                ->put('NOT_MODIFIED', 304)
                ->put('USE_PROXY', 305)
                ->put('RESERVED', 306)
                ->put('TEMPORARY_REDIRECT', 307)
                ->put('PERMANENTLY_REDIRECT', 308) // RFC7238
                ->put('BAD_REQUEST', 400)
                ->put('UNAUTHORIZED', 401)
                ->put('PAYMENT_REQUIRED', 402)
                ->put('FORBIDDEN', 403)
                ->put('NOT_FOUND', 404)
                ->put('METHOD_NOT_ALLOWED', 405)
                ->put('NOT_ACCEPTABLE', 406)
                ->put('PROXY_AUTHENTICATION_REQUIRED', 407)
                ->put('REQUEST_TIMEOUT', 408)
                ->put('CONFLICT', 409)
                ->put('GONE', 410)
                ->put('LENGTH_REQUIRED', 411)
                ->put('PRECONDITION_FAILED', 412)
                ->put('REQUEST_ENTITY_TOO_LARGE', 413)
                ->put('REQUEST_URI_TOO_LONG', 414)
                ->put('UNSUPPORTED_MEDIA_TYPE', 415)
                ->put('REQUESTED_RANGE_NOT_SATISFIABLE', 416)
                ->put('EXPECTATION_FAILED', 417)
                ->put('I_AM_A_TEAPOT', 418) // RFC2324
                ->put('UNPROCESSABLE_ENTITY', 422) // RFC4918
                ->put('LOCKED', 423) // RFC4918
                ->put('FAILED_DEPENDENCY', 424) // RFC4918
                ->put('RESERVED_FOR_WEBDAV_ADVANCED_COLLECTIONS_EXPIRED_PROPOSAL', 425) // RFC2817
                ->put('UPGRADE_REQUIRED', 426) // RFC2817
                ->put('PRECONDITION_REQUIRED', 428) // RFC6585
                ->put('TOO_MANY_REQUESTS', 429) // RFC6585
                ->put('REQUEST_HEADER_FIELDS_TOO_LARGE', 431) // RFC6585
                ->put('NO_RESPONSE', 444) // nginx
                ->put('SSL_CERTIFICATE_ERROR', 495) // nginx
                ->put('SSL_CERTIFICATE_REQUIRED', 496) // nginx
                ->put('HTTP_REQUEST_SENT_TO_HTTPS_PORT', 497) // nginx
                ->put('CLIENT_CLOSED_REQUEST', 499) // nginx
                ->put('UNAVAILABLE_FOR_LEGAL_REASONS', 451)
                ->put('INTERNAL_SERVER_ERROR', 500)
                ->put('NOT_IMPLEMENTED', 501)
                ->put('BAD_GATEWAY', 502)
                ->put('SERVICE_UNAVAILABLE', 503)
                ->put('GATEWAY_TIMEOUT', 504)
                ->put('VERSION_NOT_SUPPORTED', 505)
                ->put('VARIANT_ALSO_NEGOTIATES_EXPERIMENTAL', 506) // RFC2295
                ->put('INSUFFICIENT_STORAGE', 507) // RFC4918
                ->put('LOOP_DETECTED', 508) // RFC5842
                ->put('NOT_EXTENDED', 510) // RFC2774
                ->put('NETWORK_AUTHENTICATION_REQUIRED', 511)
                ->put('UNKNOWN_ERROR', 520) // cloudflare
                ->put('WEB_SERVER_IS_DOWN', 521) // cloudflare
                ->put('CONNECTION_TIMED_OUT', 522) // cloudflare
                ->put('ORIGIN_IS_UNREACHABLE', 523) // cloudflare
                ->put('A_TIMEOUT_OCCURED', 524) // cloudflare
                ->put('SSL_HANDSHAKE_FAILED', 525) // cloudflare
                ->put('INVALID_SSL_CERTIFICATE', 526) // cloudflare
                ->put('RAILGUN_ERROR', 527); // cloudflare
        }

        return self::$codes;
    }
}
