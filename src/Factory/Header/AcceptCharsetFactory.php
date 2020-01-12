<?php
declare(strict_types = 1);

namespace Innmind\Http\Factory\Header;

use Innmind\Http\{
    Factory\HeaderFactory as HeaderFactoryInterface,
    Header,
    Header\Value,
    Header\AcceptCharsetValue,
    Header\AcceptCharset,
    Header\Parameter\Quality,
    Exception\DomainException,
};
use Innmind\Immutable\Str;

final class AcceptCharsetFactory implements HeaderFactoryInterface
{
    private const PATTERN = '~(?<charset>[a-zA-Z0-9\-_:\(\)]+)(; ?q=(?<quality>\d+(\.\d+)?))?~';

    public function __invoke(Str $name, Str $value): Header
    {
        if ($name->toLower()->toString() !== 'accept-charset') {
            throw new DomainException($name->toString());
        }

        $values = $value->split(',');
        $values->foreach(static function(Str $accept): void {
            if (!$accept->matches(self::PATTERN)) {
                throw new DomainException($accept->toString());
            }
        });

        return new AcceptCharset(
            ...$values->reduce(
                [],
                static function(array $carry, Str $accept): array {
                    $matches = $accept->capture(self::PATTERN);
                    $carry[] = new AcceptCharsetValue(
                        $matches->get('charset')->toString(),
                        new Quality(
                            $matches->contains('quality') ?
                                (float) $matches->get('quality')->toString() : 1,
                        ),
                    );

                    return $carry;
                },
            ),
        );
    }
}
