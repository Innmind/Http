<?php
declare(strict_types = 1);

namespace Innmind\Http\Factory\Header;

use Innmind\Http\{
    Factory\HeadersFactory as HeadersFactoryInterface,
    Factory\HeaderFactory as HeaderFactoryInterface,
    Headers,
};
use Innmind\Immutable\Str;

/**
 * @psalm-immutable
 */
final class HeadersFactory implements HeadersFactoryInterface
{
    private const FORMAT = '~^(HTTP_|CONTENT_LENGTH|CONTENT_MD5|CONTENT_TYPE)~';
    private TryFactory $headerFactory;
    /** @var array<string, string> */
    private array $server;

    /**
     * @param array<string, string> $server
     */
    public function __construct(
        HeaderFactoryInterface $headerFactory,
        array $server,
    ) {
        $this->headerFactory = new TryFactory($headerFactory);
        $this->server = $server;
    }

    #[\Override]
    public function __invoke(): Headers
    {
        $headers = [];

        foreach ($this->headers() as $name => $value) {
            $headers[] = ($this->headerFactory)(
                Str::of($name),
                Str::of($value),
            );
        }

        return Headers::of(...$headers);
    }

    public static function default(HeaderFactoryInterface $headerFactory): self
    {
        /** @var array<string, string> */
        $server = $_SERVER;

        return new self($headerFactory, $server);
    }

    /**
     * @return array<string, string>
     */
    private function headers(): array
    {
        $headers = [];

        foreach ($this->server as $key => $value) {
            $key = Str::of($key);

            if (!$key->matches(self::FORMAT)) {
                continue;
            }

            $key = $key
                ->pregReplace('~^HTTP_~', '')
                ->replace('_', '-')
                ->toString();
            /** @psalm-suppress RedundantCastGivenDocblockType */
            $headers[$key] = (string) $value;
        }

        return $headers;
    }
}
