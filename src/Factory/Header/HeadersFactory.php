<?php
declare(strict_types = 1);

namespace Innmind\Http\Factory\Header;

use Innmind\Http\{
    Factory\HeadersFactory as HeadersFactoryInterface,
    Factory\HeaderFactory as HeaderFactoryInterface,
    Headers,
    Header
};
use Innmind\Immutable\{
    Map,
    Str
};

final class HeadersFactory implements HeadersFactoryInterface
{
    private const FORMAT = '~^(HTTP_|CONTENT_LENGTH|CONTENT_MD5|CONTENT_TYPE)~';
    private $headerFactory;

    public function __construct(HeaderFactoryInterface $headerFactory)
    {
        $this->headerFactory = $headerFactory;
    }

    public function make(): Headers
    {
        $map = new Map('string', Header::class);

        foreach ($this->headers() as $name => $value) {
            $map = $map->put(
                $name,
                $this->headerFactory->make(
                    new Str((string) $name),
                    new Str((string) $value)
                )
            );
        }

        return new Headers\Headers($map);
    }

    /**
     * @return array<string, string>
     */
    private function headers(): array
    {
        $headers = [];

        foreach ($_SERVER as $key => $value) {
            $key = Str::of($key);

            if (!$key->matches(self::FORMAT)) {
                continue;
            }

            $key = (string) $key
                ->pregReplace('~^HTTP_~', '')
                ->replace('_', '-');
            $headers[$key] = $value;
        }

        return $headers;
    }
}
