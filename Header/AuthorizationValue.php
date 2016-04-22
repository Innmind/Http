<?php
declare(strict_types = 1);

namespace Innmind\Http\Header;

use Innmind\Http\{
    Header\Authorization\Credentials,
    Exception\InvalidArgumentException
};
use Innmind\Immutable\StringPrimitive as Str;

final class AuthorizationValue extends HeaderValue
{
    const PATTERN = '~^"?(?<scheme>\w+)"?(\s(?<param>.*))?$~';
    private $credentials;

    public function __construct(string $value)
    {
        $value = new Str($value);

        if (!$value->match(self::PATTERN)) {
            throw new InvalidArgumentException;
        }

        parent::__construct((string) $value);
        $matches = $value->getMatches(self::PATTERN);

        $this->credentials = new Credentials(
            (string) $matches->get('scheme'),
            $matches->hasKey('param') ? (string) $matches->get('param') : ''
        );
    }

    public function credentials(): Credentials
    {
        return $this->credentials;
    }
}
