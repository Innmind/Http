<?php
declare(strict_types = 1);

namespace Innmind\Http\Translator\ServerRequest;

use Innmind\Http\{
    Translator\Request\Psr7Translator as RequestTranslator,
    Message\ServerRequest\ServerRequest,
    Message\Files,
    Message\Environment,
    Message\Cookies,
    Message\Query,
    Message\Query\Parameter as QueryParameter,
    Message\Form,
    Message\Form\Parameter as FormParameter,
    File,
    Bridge\Psr7\Stream,
    File\Status\ExceedsFormMaxFileSize,
    File\Status\ExceedsIniMaxFileSize,
    File\Status\NoTemporaryDirectory,
    File\Status\NotUploaded,
    File\Status\Ok,
    File\Status\PartiallyUploaded,
    File\Status\StoppedByExtension,
    File\Status\WriteFailed,
    File\Status,
    Exception\LogicException,
};
use Innmind\MediaType\MediaType;
use Innmind\Immutable\{
    Map,
    Maybe,
};
use Psr\Http\Message\{
    ServerRequestInterface,
    UploadedFileInterface,
};

final class Psr7Translator
{
    private RequestTranslator $requestTranslator;

    public function __construct(RequestTranslator $requestTranslator)
    {
        $this->requestTranslator = $requestTranslator;
    }

    public function __invoke(ServerRequestInterface $serverRequest): ServerRequest
    {
        $request = ($this->requestTranslator)($serverRequest);

        return new ServerRequest(
            $request->url(),
            $request->method(),
            $request->protocolVersion(),
            $request->headers(),
            $request->body(),
            $this->translateEnvironment($serverRequest->getServerParams()),
            $this->translateCookies($serverRequest->getCookieParams()),
            $this->translateQuery($serverRequest->getQueryParams()),
            $this->translateForm($serverRequest->getParsedBody()),
            $this->translateFiles($serverRequest->getUploadedFiles()),
        );
    }

    public static function default(): self
    {
        return new self(RequestTranslator::default());
    }

    private function translateEnvironment(array $params): Environment
    {
        /** @var Map<string, string> */
        $map = Map::of();

        /**
         * @var string $key
         * @var mixed $value
         */
        foreach ($params as $key => $value) {
            if (\is_string($value)) {
                $map = ($map)($key, $value);
            }
        }

        return new Environment($map);
    }

    private function translateCookies(array $params): Cookies
    {
        /** @var Map<string, string> */
        $map = Map::of();

        /**
         * @var string $key
         * @var mixed $value
         */
        foreach ($params as $key => $value) {
            if (\is_string($value)) {
                $map = ($map)($key, $value);
            }
        }

        return new Cookies($map);
    }

    private function translateQuery(array $params): Query
    {
        $queries = [];

        /**
         * @var string $key
         * @var string|array $value
         */
        foreach ($params as $key => $value) {
            $queries[] = new QueryParameter($key, $value);
        }

        return new Query(...$queries);
    }

    /**
     * @psalm-suppress MissingParamType Because of psr typing
     */
    private function translateForm($params): Form
    {
        if (!\is_array($params) && !$params instanceof \Traversable) {
            return new Form;
        }

        $forms = [];

        /**
         * @var string $key
         * @var string|array $value
         */
        foreach ($params as $key => $value) {
            $forms[] = new FormParameter($key, $value);
        }

        return new Form(...$forms);
    }

    private function translateFiles(array $files): Files
    {
        $map = [];

        /**
         * @var string $name
         * @var UploadedFileInterface $file
         */
        foreach ($files as $name => $file) {
            $mediaType = Maybe::of($file->getClientMediaType())
                ->flatMap(static fn($mediaType) => MediaType::of($mediaType))
                ->match(
                    static fn($mediaType) => $mediaType,
                    static fn() => MediaType::null(),
                );

            $map[] = new File\File(
                (string) $file->getClientFilename(),
                new Stream($file->getStream()),
                $name,
                $this->status($file->getError()),
                $mediaType,
            );
        }

        return new Files(...$map);
    }

    private function status(int $status): Status
    {
        switch ($status) {
            case \UPLOAD_ERR_FORM_SIZE:
                return new ExceedsFormMaxFileSize;
            case \UPLOAD_ERR_INI_SIZE:
                return new ExceedsIniMaxFileSize;
            case \UPLOAD_ERR_NO_TMP_DIR:
                return new NoTemporaryDirectory;
            case \UPLOAD_ERR_NO_FILE:
                return new NotUploaded;
            case \UPLOAD_ERR_OK:
                return new Ok;
            case \UPLOAD_ERR_PARTIAL:
                return new PartiallyUploaded;
            case \UPLOAD_ERR_EXTENSION:
                return new StoppedByExtension;
            case \UPLOAD_ERR_CANT_WRITE:
                return new WriteFailed;
        }

        throw new LogicException("Unknown file upload status $status");
    }
}
