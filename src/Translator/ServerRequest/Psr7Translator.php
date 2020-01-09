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
    Message\Query\Parameter as QueryParameterInterface,
    Message\Query\Parameter\Parameter as QueryParameter,
    Message\Form,
    Message\Form\Parameter as FormParameterInterface,
    Message\Form\Parameter\Parameter as FormParameter,
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
    File\Status
};
use Innmind\Filesystem\MediaType\{
    MediaType,
    NullMediaType
};
use Innmind\Immutable\Map;
use Psr\Http\Message\ServerRequestInterface;

final class Psr7Translator
{
    private $requestTranslator;

    public function __construct(RequestTranslator $requestTranslator)
    {
        $this->requestTranslator = $requestTranslator;
    }

    public function translate(ServerRequestInterface $serverRequest): ServerRequest
    {
        $request = $this->requestTranslator->translate($serverRequest);

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
            $this->translateFiles($serverRequest->getUploadedFiles())
        );
    }

    private function translateEnvironment(array $params): Environment
    {
        $map = new Map('string', 'scalar');

        foreach ($params as $key => $value) {
            if (is_scalar($value)) {
                $map = $map->put($key, $value);
            }
        }

        return new Environment($map);
    }

    private function translateCookies(array $params): Cookies
    {
        $map = new Map('string', 'scalar');

        foreach ($params as $key => $value) {
            if (is_scalar($value)) {
                $map = $map->put($key, $value);
            }
        }

        return new Cookies($map);
    }

    private function translateQuery(array $params): Query
    {
        $queries = [];

        foreach ($params as $key => $value) {
            if (is_scalar($value)) {
                $queries[] = new QueryParameter($key, $value);
            }
        }

        return new Query(...$queries);
    }

    private function translateForm($params): Form
    {
        if (!is_array($params) && !$params instanceof \Traversable) {
            return new Form;
        }

        $forms = [];

        foreach ($params as $key => $value) {
            if (is_scalar($value)) {
                $forms[] = new FormParameter($key, $value);
            }
        }

        return new Form(...$forms);
    }

    private function translateFiles(array $files): Files
    {
        $map = new Map('string', File::class);

        foreach ($files as $name => $file) {
            $mediaType = new NullMediaType;

            if (is_string($file->getClientMediaType())) {
                $mediaType = MediaType::fromString($file->getClientMediaType());
            }

            $map = $map->put(
                $name,
                new File\File(
                    $file->getClientFilename(),
                    new Stream($file->getStream()),
                    $this->status($file->getError()),
                    $mediaType
                )
            );
        }

        return new Files($map);
    }

    private function status(int $status): Status
    {
        switch ($status) {
            case UPLOAD_ERR_FORM_SIZE:
                return new ExceedsFormMaxFileSize;
            case UPLOAD_ERR_INI_SIZE:
                return new ExceedsIniMaxFileSize;
            case UPLOAD_ERR_NO_TMP_DIR:
                return new NoTemporaryDirectory;
            case UPLOAD_ERR_NO_FILE:
                return new NotUploaded;
            case UPLOAD_ERR_OK:
                return new Ok;
            case UPLOAD_ERR_PARTIAL:
                return new PartiallyUploaded;
            case UPLOAD_ERR_EXTENSION:
                return new StoppedByExtension;
            case UPLOAD_ERR_CANT_WRITE:
                return new WriteFailed;
        }
    }
}
