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
    case processing; // RFC2518
    case ok;
    case created;
    case accepted;
    case nonAuthoritativeInformation;
    case noContent;
    case resetContent;
    case partialContent;
    case multiStatus; // RFC4918
    case alreadyReported; // RFC5842
    case imUsed; // RFC3229
    case multipleChoices;
    case movedPermanently;
    case found;
    case seeOther;
    case notModified;
    case useProxy;
    case reserved; // no longer used (was 'Switch Proxy')
    case temporaryRedirect;
    case permanentlyRedirect; // RFC7238
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
    case iAmATeapot; // RFC2324
    case unprocessableEntity; // RFC4918
    case locked; // RFC4918
    case failedDependency; // RFC4918
    case reservedForWebdavAdvancedCollectionsExpiredProposal; // RFC2817
    case upgradeRequired; // RFC2817
    case preconditionRequired; // RFC6585
    case tooManyRequests; // RFC6585
    case requestHeaderFieldsTooLarge; // RFC6585
    case noResponse; // nginx
    case unavailableForLegalReasons;
    case sslCertificateError; // nginx
    case sslCertificateRequired; // nginx
    case httpRequestSentToHttpsPort; // nginx
    case clientClosedRequest; // nginx
    case internalServerError;
    case notImplemented;
    case badGateway;
    case serviceUnavailable;
    case gatewayTimeout;
    case versionNotSupported;
    case variantAlsoNegotiatesExperimental; // RFC2295
    case insufficientStorage; // RFC4918
    case loopDetected; // RFC5842
    case notExtended; // RFC2774
    case networkAuthenticationRequired;
    case unknownError; // cloudflare
    case webServerIsDown; // cloudflare
    case connectionTimedOut; // cloudflare
    case originIsUnreachable; // cloudflare
    case aTimeoutOccured; // cloudflare
    case sslHandshakeFailed; // cloudflare
    case invalidSslCertificate; // cloudflare
    case railgunError; // cloudflare

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
            306 => self::reserved,
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

    public function toInt(): int
    {
        return match ($this) {
            self::continue => 100,
            self::switchingProtocols => 101,
            self::processing => 102,
            self::ok => 200,
            self::created => 201,
            self::accepted => 202,
            self::nonAuthoritativeInformation => 203,
            self::noContent => 204,
            self::resetContent => 205,
            self::partialContent => 206,
            self::multiStatus => 207,
            self::alreadyReported => 208,
            self::imUsed => 226,
            self::multipleChoices => 300,
            self::movedPermanently => 301,
            self::found => 302,
            self::seeOther => 303,
            self::notModified => 304,
            self::useProxy => 305,
            self::reserved => 306,
            self::temporaryRedirect => 307,
            self::permanentlyRedirect => 308,
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
            self::iAmATeapot => 418,
            self::unprocessableEntity => 422,
            self::locked => 423,
            self::failedDependency => 424,
            self::reservedForWebdavAdvancedCollectionsExpiredProposal => 425,
            self::upgradeRequired => 426,
            self::preconditionRequired => 428,
            self::tooManyRequests => 429,
            self::requestHeaderFieldsTooLarge => 431,
            self::noResponse => 444,
            self::unavailableForLegalReasons => 451,
            self::sslCertificateError => 495,
            self::sslCertificateRequired => 496,
            self::httpRequestSentToHttpsPort => 497,
            self::clientClosedRequest => 499,
            self::internalServerError => 500,
            self::notImplemented => 501,
            self::badGateway => 502,
            self::serviceUnavailable => 503,
            self::gatewayTimeout => 504,
            self::versionNotSupported => 505,
            self::variantAlsoNegotiatesExperimental => 506,
            self::insufficientStorage => 507,
            self::loopDetected => 508,
            self::notExtended => 510,
            self::networkAuthenticationRequired => 511,
            self::unknownError => 520,
            self::webServerIsDown => 521,
            self::connectionTimedOut => 522,
            self::originIsUnreachable => 523,
            self::aTimeoutOccured => 524,
            self::sslHandshakeFailed => 525,
            self::invalidSslCertificate => 526,
            self::railgunError => 527,
        };
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

    /**
     * @return non-empty-string
     */
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
            self::reserved => 'Switch Proxy',
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
