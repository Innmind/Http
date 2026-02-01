<?php
declare(strict_types = 1);

namespace Innmind\Http\Response;

use Innmind\Immutable\Maybe;

/**
 * @psalm-immutable
 */
enum StatusCode: int
{
    case continue = 100;
    case switchingProtocols = 101;
    case processing = 102; // RFC2518
    case ok = 200;
    case created = 201;
    case accepted = 202;
    case nonAuthoritativeInformation = 203;
    case noContent = 204;
    case resetContent = 205;
    case partialContent = 206;
    case multiStatus = 207; // RFC4918
    case alreadyReported = 208; // RFC5842
    case imUsed = 226; // RFC3229
    case multipleChoices = 300;
    case movedPermanently = 301;
    case found = 302;
    case seeOther = 303;
    case notModified = 304;
    case useProxy = 305;
    case switchProxy = 306; // no longer used
    case temporaryRedirect = 307;
    case permanentlyRedirect = 308; // RFC7238
    case badRequest = 400;
    case unauthorized = 401;
    case paymentRequired = 402;
    case forbidden = 403;
    case notFound = 404;
    case methodNotAllowed = 405;
    case notAcceptable = 406;
    case proxyAuthenticationRequired = 407;
    case requestTimeout = 408;
    case conflict = 409;
    case gone = 410;
    case lengthRequired = 411;
    case preconditionFailed = 412;
    case requestEntityTooLarge = 413;
    case requestUriTooLong = 414;
    case unsupportedMediaType = 415;
    case requestedRangeNotSatisfiable = 416;
    case expectationFailed = 417;
    case iAmATeapot = 418; // RFC2324
    case unprocessableEntity = 422; // RFC4918
    case locked = 423; // RFC4918
    case failedDependency = 424; // RFC4918
    case reservedForWebdavAdvancedCollectionsExpiredProposal = 425; // RFC2817
    case upgradeRequired = 426; // RFC2817
    case preconditionRequired = 428; // RFC6585
    case tooManyRequests = 429; // RFC6585
    case requestHeaderFieldsTooLarge = 431; // RFC6585
    case noResponse = 444; // nginx
    case unavailableForLegalReasons = 451;
    case sslCertificateError = 495; // nginx
    case sslCertificateRequired = 496; // nginx
    case httpRequestSentToHttpsPort = 497; // nginx
    case clientClosedRequest = 499; // nginx
    case internalServerError = 500;
    case notImplemented = 501;
    case badGateway = 502;
    case serviceUnavailable = 503;
    case gatewayTimeout = 504;
    case versionNotSupported = 505;
    case variantAlsoNegotiatesExperimental = 506; // RFC2295
    case insufficientStorage = 507; // RFC4918
    case loopDetected = 508; // RFC5842
    case notExtended = 510; // RFC2774
    case networkAuthenticationRequired = 511;
    case unknownError = 520; // cloudflare
    case webServerIsDown = 521; // cloudflare
    case connectionTimedOut = 522; // cloudflare
    case originIsUnreachable = 523; // cloudflare
    case aTimeoutOccured = 524; // cloudflare
    case sslHandshakeFailed = 525; // cloudflare
    case invalidSslCertificate = 526; // cloudflare
    case railgunError = 527; // cloudflare

    /**
     * @psalm-pure
     *
     * @throws \UnhandledMatchError
     */
    #[\NoDiscard]
    public static function of(int $code): self
    {
        return match ($code) {
            100 => self::continue,
            101 => self::switchingProtocols,
            102 => self::processing,
            200 => self::ok,
            201 => self::created,
            202 => self::accepted,
            203 => self::nonAuthoritativeInformation,
            204 => self::noContent,
            205 => self::resetContent,
            206 => self::partialContent,
            207 => self::multiStatus,
            208 => self::alreadyReported,
            226 => self::imUsed,
            300 => self::multipleChoices,
            301 => self::movedPermanently,
            302 => self::found,
            303 => self::seeOther,
            304 => self::notModified,
            305 => self::useProxy,
            306 => self::switchProxy,
            307 => self::temporaryRedirect,
            308 => self::permanentlyRedirect,
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
            418 => self::iAmATeapot,
            422 => self::unprocessableEntity,
            423 => self::locked,
            424 => self::failedDependency,
            425 => self::reservedForWebdavAdvancedCollectionsExpiredProposal,
            426 => self::upgradeRequired,
            428 => self::preconditionRequired,
            429 => self::tooManyRequests,
            431 => self::requestHeaderFieldsTooLarge,
            444 => self::noResponse,
            451 => self::unavailableForLegalReasons,
            495 => self::sslCertificateError,
            496 => self::sslCertificateRequired,
            497 => self::httpRequestSentToHttpsPort,
            499 => self::clientClosedRequest,
            500 => self::internalServerError,
            501 => self::notImplemented,
            502 => self::badGateway,
            503 => self::serviceUnavailable,
            504 => self::gatewayTimeout,
            505 => self::versionNotSupported,
            506 => self::variantAlsoNegotiatesExperimental,
            507 => self::insufficientStorage,
            508 => self::loopDetected,
            510 => self::notExtended,
            511 => self::networkAuthenticationRequired,
            520 => self::unknownError,
            521 => self::webServerIsDown,
            522 => self::connectionTimedOut,
            523 => self::originIsUnreachable,
            524 => self::aTimeoutOccured,
            525 => self::sslHandshakeFailed,
            526 => self::invalidSslCertificate,
            527 => self::railgunError,
        };
    }

    /**
     * @psalm-pure
     *
     * @return Maybe<self>
     */
    #[\NoDiscard]
    public static function maybe(int $code): Maybe
    {
        try {
            return Maybe::just(self::of($code));
        } catch (\UnhandledMatchError $e) {
            /** @var Maybe<self> */
            return Maybe::nothing();
        }
    }

    #[\NoDiscard]
    public function toInt(): int
    {
        return $this->value;
    }

    /**
     * @return non-empty-string
     */
    #[\NoDiscard]
    public function toString(): string
    {
        return (string) $this->toInt();
    }

    #[\NoDiscard]
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
            self::switchProxy => StatusCode\Range::redirection,
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

    #[\NoDiscard]
    public function informational(): bool
    {
        return $this->range() === StatusCode\Range::informational;
    }

    #[\NoDiscard]
    public function successful(): bool
    {
        return $this->range() === StatusCode\Range::successful;
    }

    #[\NoDiscard]
    public function redirection(): bool
    {
        return $this->range() === StatusCode\Range::redirection;
    }

    #[\NoDiscard]
    public function clientError(): bool
    {
        return $this->range() === StatusCode\Range::clientError;
    }

    #[\NoDiscard]
    public function serverError(): bool
    {
        return $this->range() === StatusCode\Range::serverError;
    }

    /**
     * @return non-empty-string
     */
    #[\NoDiscard]
    public function reasonPhrase(): string
    {
        return match ($this) {
            self::continue => 'Continue',
            self::switchingProtocols => 'Switching Protocols',
            self::processing => 'Processing',
            self::ok => 'OK',
            self::created => 'Created',
            self::accepted => 'Accepted',
            self::nonAuthoritativeInformation => 'Non-Authoritative Information',
            self::noContent => 'No Content',
            self::resetContent => 'Reset Content',
            self::partialContent => 'Partial Content',
            self::multiStatus => 'Multi-Status',
            self::alreadyReported => 'Already Reported',
            self::imUsed => 'IM Used',
            self::multipleChoices => 'Multiple Choices',
            self::movedPermanently => 'Moved Permanently',
            self::found => 'Found',
            self::seeOther => 'See Other',
            self::notModified => 'Not Modified',
            self::useProxy => 'Use Proxy',
            self::switchProxy => 'Switch Proxy',
            self::temporaryRedirect => 'Temporary Redirect',
            self::permanentlyRedirect => 'Permanent Redirect',
            self::badRequest => 'Bad Request',
            self::unauthorized => 'Unauthorized',
            self::paymentRequired => 'Payment Required',
            self::forbidden => 'Forbidden',
            self::notFound => 'Not Found',
            self::methodNotAllowed => 'Method Not Allowed',
            self::notAcceptable => 'Not Acceptable',
            self::proxyAuthenticationRequired => 'Proxy Authentication Required',
            self::requestTimeout => 'Request Timeout',
            self::conflict => 'Conflict',
            self::gone => 'Gone',
            self::lengthRequired => 'Length Required',
            self::preconditionFailed => 'Precondition Failed',
            self::requestEntityTooLarge => 'Payload Too Large',
            self::requestUriTooLong => 'URI Too Long',
            self::unsupportedMediaType => 'Unsupported Media Type',
            self::requestedRangeNotSatisfiable => 'Range Not Satisfiable',
            self::expectationFailed => 'Expectation Failed',
            self::iAmATeapot => 'I\'m a teapot',
            self::unprocessableEntity => 'Unprocessable Entity',
            self::locked => 'Locked',
            self::failedDependency => 'Failed Dependency',
            self::reservedForWebdavAdvancedCollectionsExpiredProposal => 'Reserved for WebDAV advanced collections expired proposal',
            self::upgradeRequired => 'Upgrade Required',
            self::preconditionRequired => 'Precondition Required',
            self::tooManyRequests => 'Too Many Requests',
            self::requestHeaderFieldsTooLarge => 'Request Header Fields Too Large',
            self::noResponse => 'No Response',
            self::unavailableForLegalReasons => 'Unavailable For Legal Reasons',
            self::sslCertificateError => 'SSL Certificate Error',
            self::sslCertificateRequired => 'SSL Certificate Required',
            self::httpRequestSentToHttpsPort => 'HTTP Request Sent to HTTPS Port',
            self::clientClosedRequest => 'Client Closed Request',
            self::internalServerError => 'Internal Server Error',
            self::notImplemented => 'Not Implemented',
            self::badGateway => 'Bad Gateway',
            self::serviceUnavailable => 'Service Unavailable',
            self::gatewayTimeout => 'Gateway Timeout',
            self::versionNotSupported => 'HTTP Version Not Supported',
            self::variantAlsoNegotiatesExperimental => 'Variant Also Negotiates (Experimental)',
            self::insufficientStorage => 'Insufficient Storage',
            self::loopDetected => 'Loop Detected',
            self::notExtended => 'Not Extended',
            self::networkAuthenticationRequired => 'Network Authentication Required',
            self::unknownError => 'Unknown Error',
            self::webServerIsDown => 'Web Server Is Down',
            self::connectionTimedOut => 'Connection Timed Out',
            self::originIsUnreachable => 'Origin Is Unreachable',
            self::aTimeoutOccured => 'A Timeout Occurred',
            self::sslHandshakeFailed => 'SSL Handshake Failed',
            self::invalidSslCertificate => 'Invalid SSL Certificate',
            self::railgunError => 'Railgun Error',
        };
    }
}
