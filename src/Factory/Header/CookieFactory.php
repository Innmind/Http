<?php
declare(strict_types = 1);

namespace Innmind\Http\Factory\Header;

use Innmind\Http\{
    Factory\HeaderFactory as HeaderFactoryInterface,
    Header,
    Header\Cookie,
    Header\CookieValue,
    Header\Parameter\Parameter,
    Exception\DomainException
};
use Innmind\Immutable\{
    Str,
    SequenceInterface,
    Sequence
};

final class CookieFactory implements HeaderFactoryInterface
{
    const PATTERN = '~^(\w+=\"?[\w\-.]*\"?)?(; ?\w+=\"?[\w\-.]*\"?)*$~';

    public function __invoke(Str $name, Str $value): Header
    {
        if (
            (string) $name->toLower() !== 'cookie' ||
            !$value->matches(self::PATTERN)
        ) {
            throw new DomainException;
        }

        return new Cookie(
            new CookieValue(
                ...$this->buildParams($value)
            )
        );
    }

    private function buildParams(Str $params): SequenceInterface
    {
        return $params
            ->split(';')
            ->map(static function(Str $value): Str {
                return $value->trim();
            })
            ->filter(static function(Str $value): bool {
                return $value->length() > 0;
            })
            ->reduce(
                new Sequence,
                static function(SequenceInterface $carry, Str $value): SequenceInterface {
                    $matches = $value->capture('~^(?<key>\w+)=\"?(?<value>[\w\-.]*)\"?$~');

                    return $carry->add(
                        new Parameter(
                            (string) $matches->get('key'),
                            (string) $matches->get('value')
                        )
                    );
                }
            );
    }
}
