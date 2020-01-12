<?php
declare(strict_types = 1);

namespace Innmind\Http\Message;

use Innmind\Http\Exception\DomainException;
use Innmind\Immutable\Map;

final class ReasonPhrase
{
    private static ?Map $defaults = null;
    private string $phrase;

    public function __construct(string $phrase)
    {
        if ($phrase === '') {
            throw new DomainException;
        }

        $this->phrase = $phrase;
    }

    public function toString(): string
    {
        return $this->phrase;
    }

    public static function of(int $statusCode): self
    {
        return new self(self::defaults()->get($statusCode));
    }

    /**
     * @return Map<int, string>
     */
    public static function defaults(): Map
    {
        if (self::$defaults === null) {
            self::$defaults = Map::of('int', 'string')
                ->put(100, 'Continue')
                ->put(101, 'Switching Protocols')
                ->put(102, 'Processing') // RFC2518
                ->put(200, 'OK')
                ->put(201, 'Created')
                ->put(202, 'Accepted')
                ->put(203, 'Non-Authoritative Information')
                ->put(204, 'No Content')
                ->put(205, 'Reset Content')
                ->put(206, 'Partial Content')
                ->put(207, 'Multi-Status') // RFC4918
                ->put(208, 'Already Reported') // RFC5842
                ->put(226, 'IM Used') // RFC3229
                ->put(300, 'Multiple Choices')
                ->put(301, 'Moved Permanently')
                ->put(302, 'Found')
                ->put(303, 'See Other')
                ->put(304, 'Not Modified')
                ->put(305, 'Use Proxy')
                ->put(306, 'Switch Proxy')
                ->put(307, 'Temporary Redirect')
                ->put(308, 'Permanent Redirect') // RFC7238
                ->put(400, 'Bad Request')
                ->put(401, 'Unauthorized')
                ->put(402, 'Payment Required')
                ->put(403, 'Forbidden')
                ->put(404, 'Not Found')
                ->put(405, 'Method Not Allowed')
                ->put(406, 'Not Acceptable')
                ->put(407, 'Proxy Authentication Required')
                ->put(408, 'Request Timeout')
                ->put(409, 'Conflict')
                ->put(410, 'Gone')
                ->put(411, 'Length Required')
                ->put(412, 'Precondition Failed')
                ->put(413, 'Payload Too Large')
                ->put(414, 'URI Too Long')
                ->put(415, 'Unsupported Media Type')
                ->put(416, 'Range Not Satisfiable')
                ->put(417, 'Expectation Failed')
                ->put(418, 'I\'m a teapot') // RFC2324
                ->put(422, 'Unprocessable Entity') // RFC4918
                ->put(423, 'Locked') // RFC4918
                ->put(424, 'Failed Dependency') // RFC4918
                ->put(425, 'Reserved for WebDAV advanced collections expired proposal') // RFC2817
                ->put(426, 'Upgrade Required') // RFC2817
                ->put(428, 'Precondition Required') // RFC6585
                ->put(429, 'Too Many Requests') // RFC6585
                ->put(431, 'Request Header Fields Too Large') // RFC6585
                ->put(444, 'No Response') // nginx
                ->put(495, 'SSL Certificate Error') // nginx
                ->put(496, 'SSL Certificate Required') // nginx
                ->put(497, 'HTTP Request Sent to HTTPS Port') // nginx
                ->put(499, 'Client Closed Request') // nginx
                ->put(451, 'Unavailable For Legal Reasons') // RFC7725
                ->put(500, 'Internal Server Error')
                ->put(501, 'Not Implemented')
                ->put(502, 'Bad Gateway')
                ->put(503, 'Service Unavailable')
                ->put(504, 'Gateway Timeout')
                ->put(505, 'HTTP Version Not Supported')
                ->put(506, 'Variant Also Negotiates (Experimental)') // RFC2295
                ->put(507, 'Insufficient Storage') // RFC4918
                ->put(508, 'Loop Detected') // RFC5842
                ->put(510, 'Not Extended') // RFC2774
                ->put(511, 'Network Authentication Required') // RFC6585
                ->put(520, 'Unknown Error') // cloudflare
                ->put(521, 'Web Server Is Down') // cloudflare
                ->put(522, 'Connection Timed Out') // cloudflare
                ->put(523, 'Origin Is Unreachable') // cloudflare
                ->put(524, 'A Timeout Occurred') // cloudflare
                ->put(525, 'SSL Handshake Failed') // cloudflare
                ->put(526, 'Invalid SSL Certificate') // cloudflare
                ->put(527, 'Railgun Error'); // cloudflare
        }

        return self::$defaults;
    }
}
