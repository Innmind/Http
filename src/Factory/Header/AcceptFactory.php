<?php
declare(strict_types = 1);

namespace Innmind\Http\Factory\Header;

use Innmind\Http\{
    Factory\HeaderFactory as HeaderFactoryInterface,
    Header,
    Header\Value,
    Header\AcceptValue,
    Header\Accept,
    Header\Parameter,
    Exception\DomainException,
};
use Innmind\Immutable\Str;

final class AcceptFactory implements HeaderFactoryInterface
{
    private const PATTERN = '~(?<type>[\w*]+)/(?<subType>[\w*]+)(?<params>(; ?\w+=\"?[\w\-.]+\"?)+)?~';

    public function __invoke(Str $name, Str $value): Header
    {
        if ($name->toLower()->toString() !== 'accept') {
            throw new DomainException($name->toString());
        }

        $values = $value->split(',');
        $values->foreach(static function(Str $accept): void {
            if (!$accept->matches(self::PATTERN)) {
                throw new DomainException($accept->toString());
            }
        });

        return new Accept(
            ...$values->reduce(
                [],
                function(array $carry, Str $accept): array {
                    $matches = $accept->capture(self::PATTERN);
                    $carry[] = new AcceptValue(
                        $matches->get('type')->toString(),
                        $matches->get('subType')->toString(),
                        ...$this->buildParams(
                            $matches->contains('params') ?
                                $matches->get('params') : Str::of(''),
                        ),
                    );

                    return $carry;
                },
            ),
        );
    }

    private function buildParams(Str $params): array
    {
        return $params
            ->split(';')
            ->filter(static function(Str $value): bool {
                return !$value->trim()->empty();
            })
            ->reduce(
                [],
                static function(array $carry, Str $value): array {
                    $matches = $value->capture('~(?<key>\w+)=\"?(?<value>[\w\-.]+)\"?~');
                    $carry[] = new Parameter\Parameter(
                        $matches->get('key')->toString(),
                        $matches->get('value')->toString(),
                    );

                    return $carry;
                }
            );
    }
}
