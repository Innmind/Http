<?php
declare(strict_types = 1);

namespace Innmind\Http\Factory\Header;

use Innmind\Http\{
    Factory\HeaderFactory as HeaderFactoryInterface,
    Header,
    Header\ContentType,
    Header\ContentTypeValue,
    Header\Parameter,
    Exception\DomainException,
};
use Innmind\Immutable\Str;

final class ContentTypeFactory implements HeaderFactoryInterface
{
    private const PATTERN = '~(?<type>[\w*]+)/(?<subType>[\w*]+)(?<params>(; ?\w+=\"?[\w\-.]+\"?)+)?~';

    public function __invoke(Str $name, Str $value): Header
    {
        if (
            $name->toLower()->toString() !== 'content-type' ||
            !$value->matches(self::PATTERN)
        ) {
            throw new DomainException($name->toString());
        }

        $matches = $value->capture(self::PATTERN);

        return new ContentType(
            new ContentTypeValue(
                $matches->get('type')->toString(),
                $matches->get('subType')->toString(),
                ...$this->buildParams(
                    $matches->contains('params') ?
                        $matches->get('params') : Str::of(''),
                ),
            ),
        );
    }

    /**
     * @return list<Parameter>
     */
    private function buildParams(Str $params): array
    {
        /** @var list<Parameter> */
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
                },
            );
    }
}
