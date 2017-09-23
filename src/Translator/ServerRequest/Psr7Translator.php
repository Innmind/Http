<?php
declare(strict_types = 1);

namespace Innmind\Http\Translator\ServerRequest;

use Innmind\Http\{
    Translator\Request\Psr7Translator as RequestTranslator,
    Message\ServerRequest\ServerRequest,
    Message\Files\Files,
    Message\Environment\Environment,
    Message\Cookies\Cookies,
    Message\Query\Query,
    Message\Query\Parameter as QueryParameterInterface,
    Message\Query\Parameter\Parameter as QueryParameter,
    Message\Form\Form,
    Message\Form\Parameter as FormParameterInterface,
    Message\Form\Parameter\Parameter as FormParameter,
    File,
    Bridge\Psr7\Stream,
    File\Status\ExceedsFormMaxFileSizeStatus,
    File\Status\ExceedsIniMaxFileSizeStatus,
    File\Status\NoTemporaryDirectoryStatus,
    File\Status\NotUploadedStatus,
    File\Status\OkStatus,
    File\Status\PartiallyUploadedStatus,
    File\Status\StoppedByExtensionStatus,
    File\Status\WriteFailedStatus,
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
        $map = new Map('string', QueryParameterInterface::class);

        foreach ($params as $key => $value) {
            if (is_scalar($value)) {
                $map = $map->put(
                    $key,
                    new QueryParameter($key, $value)
                );
            }
        }

        return new Query($map);
    }

    private function translateForm(array $params): Form
    {
        $map = new Map('scalar', FormParameterInterface::class);

        foreach ($params as $key => $value) {
            if (is_scalar($value)) {
                $map = $map->put(
                    $key,
                    new FormParameter($key, $value)
                );
            }
        }

        return new Form($map);
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
                return new ExceedsFormMaxFileSizeStatus;
            case UPLOAD_ERR_INI_SIZE:
                return new ExceedsIniMaxFileSizeStatus;
            case UPLOAD_ERR_NO_TMP_DIR:
                return new NoTemporaryDirectoryStatus;
            case UPLOAD_ERR_NO_FILE:
                return new NotUploadedStatus;
            case UPLOAD_ERR_OK:
                return new OkStatus;
            case UPLOAD_ERR_PARTIAL:
                return new PartiallyUploadedStatus;
            case UPLOAD_ERR_EXTENSION:
                return new StoppedByExtensionStatus;
            case UPLOAD_ERR_CANT_WRITE:
                return new WriteFailedStatus;
        }
    }
}
