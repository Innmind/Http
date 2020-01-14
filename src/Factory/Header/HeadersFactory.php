<?php
declare(strict_types = 1);

namespace Innmind\Http\Factory\Header;

use Innmind\Http\{
    Factory\HeadersFactory as HeadersFactoryInterface,
    Factory\HeaderFactory as HeaderFactoryInterface,
    Headers,
    Header,
};
use Innmind\Immutable\Str;

final class HeadersFactory implements HeadersFactoryInterface
{
    private const FORMAT = '~^(HTTP_|CONTENT_LENGTH|CONTENT_MD5|CONTENT_TYPE)~';
    private HeaderFactoryInterface $headerFactory;

    public function __construct(HeaderFactoryInterface $headerFactory)
    {
        $this->headerFactory = $headerFactory;
    }

    public function __invoke(): Headers
    {
        $headers = [];

        foreach ($this->headers() as $name => $value) {
            $headers[] = ($this->headerFactory)(
                Str::of((string) $name),
                Str::of((string) $value),
            );
        }

        return new Headers(...$headers);
    }

    /**
     * @return array<string, string>
     */
    private function headers(): array
    {
        $headers = [];

        /**
         * @var string $key
         * @var string $value
         */
        foreach ($_SERVER as $key => $value) {
            $key = Str::of($key);

            if (!$key->matches(self::FORMAT)) {
                continue;
            }

            $key = $key
                ->pregReplace('~^HTTP_~', '')
                ->replace('_', '-')
                ->toString();
            $headers[$key] = $value;
        }

        return $headers;
    }
}
