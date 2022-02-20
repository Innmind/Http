<?php
declare(strict_types = 1);

namespace Innmind\Http\Message;

/**
 * @psalm-immutable
 */
enum StatusCode
{
    case continue;
    case switchingProtocols;
    case processing;
    case ok;
    case created;
    case accepted;
    case nonAuthoritativeInformation;
    case noContent;
    case resetContent;
    case partialContent;
    case multiStatus;
    case alreadyReported;
    case imUsed;
    case multipleChoices;
    case movedPermanently;
    case found;
    case seeOther;
    case notModified;
    case useProxy;
    case reserved;
    case temporaryRedirect;
    case permanentlyRedirect;
    case badRequest;
    case unauthorized;
    case paymentRequired;
    case forbidden;
    case notFound;
    case methodNotAllowed;
    case notAcceptable;
    case proxyAuthenticationRequired;
    case requestTimeout;
    case conflict;
    case gone;
    case lengthRequired;
    case preconditionFailed;
    case requestEntityTooLarge;
    case requestUriTooLong;
    case unsupportedMediaType;
    case requestedRangeNotSatisfiable;
    case expectationFailed;
    case iAmATeapot;
    case unprocessableEntity;
    case locked;
    case failedDependency;
    case reservedForWebdavAdvancedCollectionsExpiredProposal;
    case upgradeRequired;
    case preconditionRequired;
    case tooManyRequests;
    case requestHeaderFieldsTooLarge;
    case noResponse;
    case unavailableForLegalReasons;
    case sslCertificateError;
    case sslCertificateRequired;
    case httpRequestSentToHttpsPort;
    case clientClosedRequest;
    case internalServerError;
    case notImplemented;
    case badGateway;
    case serviceUnavailable;
    case gatewayTimeout;
    case versionNotSupported;
    case variantAlsoNegotiatesExperimental;
    case insufficientStorage;
    case loopDetected;
    case notExtended;
    case networkAuthenticationRequired;
    case unknownError;
    case webServerIsDown;
    case connectionTimedOut;
    case originIsUnreachable;
    case aTimeoutOccured;
    case sslHandshakeFailed;
    case invalidSslCertificate;
    case railgunError;

    /**
     * @psalm-pure
     *
     * @throws \UnhandledMatchError
     */
    public static function of(int $code): self
    {
        return match ($code) {
            100 => self::continue,
            101 => self::switchingProtocols,
            102 => self::processing, // RFC2518
            200 => self::ok,
            201 => self::created,
            202 => self::accepted,
            203 => self::nonAuthoritativeInformation,
            204 => self::noContent,
            205 => self::resetContent,
            206 => self::partialContent,
            207 => self::multiStatus, // RFC4918
            208 => self::alreadyReported, // RFC5842
            226 => self::imUsed, // RFC3229
            300 => self::multipleChoices,
            301 => self::movedPermanently,
            302 => self::found,
            303 => self::seeOther,
            304 => self::notModified,
            305 => self::useProxy,
            306 => self::reserved,
            307 => self::temporaryRedirect,
            308 => self::permanentlyRedirect, // RFC7238
            400 => self::badRequest,
            401 => self::unauthorized,
            402 => self::paymentRequired,
            403 => self::forbidden,
            404 => self::notFound,
            405 => self::methodNotAllowed,
            406 => self::notAcceptable,
            407 => self::proxyAuthenticationRequired,
            408 => self::requestTimeout,
            409 => self::conflict,
            410 => self::gone,
            411 => self::lengthRequired,
            412 => self::preconditionFailed,
            413 => self::requestEntityTooLarge,
            414 => self::requestUriTooLong,
            415 => self::unsupportedMediaType,
            416 => self::requestedRangeNotSatisfiable,
            417 => self::expectationFailed,
            418 => self::iAmATeapot, // RFC2324
            422 => self::unprocessableEntity, // RFC4918
            423 => self::locked, // RFC4918
            424 => self::failedDependency, // RFC4918
            425 => self::reservedForWebdavAdvancedCollectionsExpiredProposal, // RFC2817
            426 => self::upgradeRequired, // RFC2817
            428 => self::preconditionRequired, // RFC6585
            429 => self::tooManyRequests, // RFC6585
            431 => self::requestHeaderFieldsTooLarge, // RFC6585
            444 => self::noResponse, // nginx
            451 => self::unavailableForLegalReasons,
            495 => self::sslCertificateError, // nginx
            496 => self::sslCertificateRequired, // nginx
            497 => self::httpRequestSentToHttpsPort, // nginx
            499 => self::clientClosedRequest, // nginx
            500 => self::internalServerError,
            501 => self::notImplemented,
            502 => self::badGateway,
            503 => self::serviceUnavailable,
            504 => self::gatewayTimeout,
            505 => self::versionNotSupported,
            506 => self::variantAlsoNegotiatesExperimental, // RFC2295
            507 => self::insufficientStorage, // RFC4918
            508 => self::loopDetected, // RFC5842
            510 => self::notExtended, // RFC2774
            511 => self::networkAuthenticationRequired,
            520 => self::unknownError, // cloudflare
            521 => self::webServerIsDown, // cloudflare
            522 => self::connectionTimedOut, // cloudflare
            523 => self::originIsUnreachable, // cloudflare
            524 => self::aTimeoutOccured, // cloudflare
            525 => self::sslHandshakeFailed, // cloudflare
            526 => self::invalidSslCertificate, // cloudflare
            527 => self::railgunError, // cloudflare
        };
    }

    public function toInt(): int
    {
        return match ($this) {
            self::continue => 100,
            self::switchingProtocols => 101,
            self::processing => 102, // RFC2518
            self::ok => 200,
            self::created => 201,
            self::accepted => 202,
            self::nonAuthoritativeInformation => 203,
            self::noContent => 204,
            self::resetContent => 205,
            self::partialContent => 206,
            self::multiStatus => 207, // RFC4918
            self::alreadyReported => 208, // RFC5842
            self::imUsed => 226, // RFC3229
            self::multipleChoices => 300,
            self::movedPermanently => 301,
            self::found => 302,
            self::seeOther => 303,
            self::notModified => 304,
            self::useProxy => 305,
            self::reserved => 306,
            self::temporaryRedirect => 307,
            self::permanentlyRedirect => 308, // RFC7238
            self::badRequest => 400,
            self::unauthorized => 401,
            self::paymentRequired => 402,
            self::forbidden => 403,
            self::notFound => 404,
            self::methodNotAllowed => 405,
            self::notAcceptable => 406,
            self::proxyAuthenticationRequired => 407,
            self::requestTimeout => 408,
            self::conflict => 409,
            self::gone => 410,
            self::lengthRequired => 411,
            self::preconditionFailed => 412,
            self::requestEntityTooLarge => 413,
            self::requestUriTooLong => 414,
            self::unsupportedMediaType => 415,
            self::requestedRangeNotSatisfiable => 416,
            self::expectationFailed => 417,
            self::iAmATeapot => 418, // RFC2324
            self::unprocessableEntity => 422, // RFC4918
            self::locked => 423, // RFC4918
            self::failedDependency => 424, // RFC4918
            self::reservedForWebdavAdvancedCollectionsExpiredProposal => 425, // RFC2817
            self::upgradeRequired => 426, // RFC2817
            self::preconditionRequired => 428, // RFC6585
            self::tooManyRequests => 429, // RFC6585
            self::requestHeaderFieldsTooLarge => 431, // RFC6585
            self::noResponse => 444, // nginx
            self::unavailableForLegalReasons => 451,
            self::sslCertificateError => 495, // nginx
            self::sslCertificateRequired => 496, // nginx
            self::httpRequestSentToHttpsPort => 497, // nginx
            self::clientClosedRequest => 499, // nginx
            self::internalServerError => 500,
            self::notImplemented => 501,
            self::badGateway => 502,
            self::serviceUnavailable => 503,
            self::gatewayTimeout => 504,
            self::versionNotSupported => 505,
            self::variantAlsoNegotiatesExperimental => 506, // RFC2295
            self::insufficientStorage => 507, // RFC4918
            self::loopDetected => 508, // RFC5842
            self::notExtended => 510, // RFC2774
            self::networkAuthenticationRequired => 511,
            self::unknownError => 520, // cloudflare
            self::webServerIsDown => 521, // cloudflare
            self::connectionTimedOut => 522, // cloudflare
            self::originIsUnreachable => 523, // cloudflare
            self::aTimeoutOccured => 524, // cloudflare
            self::sslHandshakeFailed => 525, // cloudflare
            self::invalidSslCertificate => 526, // cloudflare
            self::railgunError => 527, // cloudflare
        };
    }

    public function associatedReasonPhrase(): ReasonPhrase
    {
        return ReasonPhrase::of($this->toInt());
    }

    /**
     * @return non-empty-string
     */
    public function toString(): string
    {
        return (string) $this->toInt();
    }

    public function range(): StatusCode\Range
    {
        return match ($this) {
            self::continue => StatusCode\Range::informational,
            self::switchingProtocols => StatusCode\Range::informational,
            self::processing => StatusCode\Range::informational,
            self::ok => StatusCode\Range::successful,
            self::created => StatusCode\Range::successful,
            self::accepted => StatusCode\Range::successful,
            self::nonAuthoritativeInformation => StatusCode\Range::successful,
            self::noContent => StatusCode\Range::successful,
            self::resetContent => StatusCode\Range::successful,
            self::partialContent => StatusCode\Range::successful,
            self::multiStatus => StatusCode\Range::successful,
            self::alreadyReported => StatusCode\Range::successful,
            self::imUsed => StatusCode\Range::successful,
            self::multipleChoices => StatusCode\Range::redirection,
            self::movedPermanently => StatusCode\Range::redirection,
            self::found => StatusCode\Range::redirection,
            self::seeOther => StatusCode\Range::redirection,
            self::notModified => StatusCode\Range::redirection,
            self::useProxy => StatusCode\Range::redirection,
            self::reserved => StatusCode\Range::redirection,
            self::temporaryRedirect => StatusCode\Range::redirection,
            self::permanentlyRedirect => StatusCode\Range::redirection,
            self::badRequest => StatusCode\Range::clientError,
            self::unauthorized => StatusCode\Range::clientError,
            self::paymentRequired => StatusCode\Range::clientError,
            self::forbidden => StatusCode\Range::clientError,
            self::notFound => StatusCode\Range::clientError,
            self::methodNotAllowed => StatusCode\Range::clientError,
            self::notAcceptable => StatusCode\Range::clientError,
            self::proxyAuthenticationRequired => StatusCode\Range::clientError,
            self::requestTimeout => StatusCode\Range::clientError,
            self::conflict => StatusCode\Range::clientError,
            self::gone => StatusCode\Range::clientError,
            self::lengthRequired => StatusCode\Range::clientError,
            self::preconditionFailed => StatusCode\Range::clientError,
            self::requestEntityTooLarge => StatusCode\Range::clientError,
            self::requestUriTooLong => StatusCode\Range::clientError,
            self::unsupportedMediaType => StatusCode\Range::clientError,
            self::requestedRangeNotSatisfiable => StatusCode\Range::clientError,
            self::expectationFailed => StatusCode\Range::clientError,
            self::iAmATeapot => StatusCode\Range::clientError,
            self::unprocessableEntity => StatusCode\Range::clientError,
            self::locked => StatusCode\Range::clientError,
            self::failedDependency => StatusCode\Range::clientError,
            self::reservedForWebdavAdvancedCollectionsExpiredProposal => StatusCode\Range::clientError,
            self::upgradeRequired => StatusCode\Range::clientError,
            self::preconditionRequired => StatusCode\Range::clientError,
            self::tooManyRequests => StatusCode\Range::clientError,
            self::requestHeaderFieldsTooLarge => StatusCode\Range::clientError,
            self::noResponse => StatusCode\Range::clientError,
            self::unavailableForLegalReasons => StatusCode\Range::clientError,
            self::sslCertificateError => StatusCode\Range::clientError,
            self::sslCertificateRequired => StatusCode\Range::clientError,
            self::httpRequestSentToHttpsPort => StatusCode\Range::clientError,
            self::clientClosedRequest => StatusCode\Range::clientError,
            self::internalServerError => StatusCode\Range::serverError,
            self::notImplemented => StatusCode\Range::serverError,
            self::badGateway => StatusCode\Range::serverError,
            self::serviceUnavailable => StatusCode\Range::serverError,
            self::gatewayTimeout => StatusCode\Range::serverError,
            self::versionNotSupported => StatusCode\Range::serverError,
            self::variantAlsoNegotiatesExperimental => StatusCode\Range::serverError,
            self::insufficientStorage => StatusCode\Range::serverError,
            self::loopDetected => StatusCode\Range::serverError,
            self::notExtended => StatusCode\Range::serverError,
            self::networkAuthenticationRequired => StatusCode\Range::serverError,
            self::unknownError => StatusCode\Range::serverError,
            self::webServerIsDown => StatusCode\Range::serverError,
            self::connectionTimedOut => StatusCode\Range::serverError,
            self::originIsUnreachable => StatusCode\Range::serverError,
            self::aTimeoutOccured => StatusCode\Range::serverError,
            self::sslHandshakeFailed => StatusCode\Range::serverError,
            self::invalidSslCertificate => StatusCode\Range::serverError,
            self::railgunError => StatusCode\Range::serverError,
        };
    }

    public function informational(): bool
    {
        return $this->range() === StatusCode\Range::informational;
    }

    public function successful(): bool
    {
        return $this->range() === StatusCode\Range::successful;
    }

    public function redirection(): bool
    {
        return $this->range() === StatusCode\Range::redirection;
    }

    public function clientError(): bool
    {
        return $this->range() === StatusCode\Range::clientError;
    }

    public function serverError(): bool
    {
        return $this->range() === StatusCode\Range::serverError;
    }
}
