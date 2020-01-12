<?php
declare(strict_types = 1);

namespace Innmind\Http\Message;

use Innmind\Http\Exception\DomainException;
use Innmind\Immutable\Map;

final class StatusCode
{
    private static ?Map $codes = null;
    private int $code;

    public function __construct(int $code)
    {
        if (!self::codes()->values()->contains($code)) {
            throw new DomainException((string) $code);
        }

        $this->code = $code;
    }

    public function associatedReasonPhrase(): ReasonPhrase
    {
        return ReasonPhrase::of($this->code);
    }

    public function value(): int
    {
        return $this->code;
    }

    public function toString(): string
    {
        return (string) $this->code;
    }

    public static function of(string $name): self
    {
        return new self(self::codes()->get($name));
    }

    public function isInformational(): bool
    {
        return ((int) ($this->value() / 100)) === 1;
    }

    public function isSuccessful(): bool
    {
        return ((int) ($this->value() / 100)) === 2;
    }

    public function isRedirection(): bool
    {
        return ((int) ($this->value() / 100)) === 3;
    }

    public function isClientError(): bool
    {
        return ((int) ($this->value() / 100)) === 4;
    }

    public function isServerError(): bool
    {
        return ((int) ($this->value() / 100)) === 5;
    }

    /**
     * @return Map<string, int>
     */
    public static function codes(): Map
    {
        return self::$codes ?? self::$codes = Map::of('string', 'int')
            ('CONTINUE', 100)
            ('SWITCHING_PROTOCOLS', 101)
            ('PROCESSING', 102) // RFC2518
            ('OK', 200)
            ('CREATED', 201)
            ('ACCEPTED', 202)
            ('NON_AUTHORITATIVE_INFORMATION', 203)
            ('NO_CONTENT', 204)
            ('RESET_CONTENT', 205)
            ('PARTIAL_CONTENT', 206)
            ('MULTI_STATUS', 207) // RFC4918
            ('ALREADY_REPORTED', 208) // RFC5842
            ('IM_USED', 226) // RFC3229
            ('MULTIPLE_CHOICES', 300)
            ('MOVED_PERMANENTLY', 301)
            ('FOUND', 302)
            ('SEE_OTHER', 303)
            ('NOT_MODIFIED', 304)
            ('USE_PROXY', 305)
            ('RESERVED', 306)
            ('TEMPORARY_REDIRECT', 307)
            ('PERMANENTLY_REDIRECT', 308) // RFC7238
            ('BAD_REQUEST', 400)
            ('UNAUTHORIZED', 401)
            ('PAYMENT_REQUIRED', 402)
            ('FORBIDDEN', 403)
            ('NOT_FOUND', 404)
            ('METHOD_NOT_ALLOWED', 405)
            ('NOT_ACCEPTABLE', 406)
            ('PROXY_AUTHENTICATION_REQUIRED', 407)
            ('REQUEST_TIMEOUT', 408)
            ('CONFLICT', 409)
            ('GONE', 410)
            ('LENGTH_REQUIRED', 411)
            ('PRECONDITION_FAILED', 412)
            ('REQUEST_ENTITY_TOO_LARGE', 413)
            ('REQUEST_URI_TOO_LONG', 414)
            ('UNSUPPORTED_MEDIA_TYPE', 415)
            ('REQUESTED_RANGE_NOT_SATISFIABLE', 416)
            ('EXPECTATION_FAILED', 417)
            ('I_AM_A_TEAPOT', 418) // RFC2324
            ('UNPROCESSABLE_ENTITY', 422) // RFC4918
            ('LOCKED', 423) // RFC4918
            ('FAILED_DEPENDENCY', 424) // RFC4918
            ('RESERVED_FOR_WEBDAV_ADVANCED_COLLECTIONS_EXPIRED_PROPOSAL', 425) // RFC2817
            ('UPGRADE_REQUIRED', 426) // RFC2817
            ('PRECONDITION_REQUIRED', 428) // RFC6585
            ('TOO_MANY_REQUESTS', 429) // RFC6585
            ('REQUEST_HEADER_FIELDS_TOO_LARGE', 431) // RFC6585
            ('NO_RESPONSE', 444) // nginx
            ('SSL_CERTIFICATE_ERROR', 495) // nginx
            ('SSL_CERTIFICATE_REQUIRED', 496) // nginx
            ('HTTP_REQUEST_SENT_TO_HTTPS_PORT', 497) // nginx
            ('CLIENT_CLOSED_REQUEST', 499) // nginx
            ('UNAVAILABLE_FOR_LEGAL_REASONS', 451)
            ('INTERNAL_SERVER_ERROR', 500)
            ('NOT_IMPLEMENTED', 501)
            ('BAD_GATEWAY', 502)
            ('SERVICE_UNAVAILABLE', 503)
            ('GATEWAY_TIMEOUT', 504)
            ('VERSION_NOT_SUPPORTED', 505)
            ('VARIANT_ALSO_NEGOTIATES_EXPERIMENTAL', 506) // RFC2295
            ('INSUFFICIENT_STORAGE', 507) // RFC4918
            ('LOOP_DETECTED', 508) // RFC5842
            ('NOT_EXTENDED', 510) // RFC2774
            ('NETWORK_AUTHENTICATION_REQUIRED', 511)
            ('UNKNOWN_ERROR', 520) // cloudflare
            ('WEB_SERVER_IS_DOWN', 521) // cloudflare
            ('CONNECTION_TIMED_OUT', 522) // cloudflare
            ('ORIGIN_IS_UNREACHABLE', 523) // cloudflare
            ('A_TIMEOUT_OCCURED', 524) // cloudflare
            ('SSL_HANDSHAKE_FAILED', 525) // cloudflare
            ('INVALID_SSL_CERTIFICATE', 526) // cloudflare
            ('RAILGUN_ERROR', 527); // cloudflare
    }
}
