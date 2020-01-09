<?php
declare(strict_types = 1);

namespace Innmind\Http\Translator\ServerRequest;

use Innmind\Http\{
    Message\ServerRequest,
    Message\Method,
    Message\Environment\Environment,
    Message\Cookies\Cookies,
    Message\Query,
    Message\Form,
    Message\Files,
    Factory\HeaderFactory,
    ProtocolVersion,
    Headers,
    Header,
    File,
    File\Status,
    File\Status\Ok as OkStatus,
    File\Status\ExceedsFormMaxFileSize as ExceedsFormMaxFileSizeStatus,
    File\Status\ExceedsIniMaxFileSize as ExceedsIniMaxFileSizeStatus,
    File\Status\NoTemporaryDirectory as NoTemporaryDirectoryStatus,
    File\Status\NotUploaded as NotUploadedStatus,
    File\Status\PartiallyUploaded as PartiallyUploadedStatus,
    File\Status\StoppedByExtension as StoppedByExtensionStatus,
    File\Status\WriteFailed as WriteFailedStatus
};
use Innmind\Url\Url;
use Innmind\Stream\Readable\Stream;
use Innmind\Filesystem\MediaType\MediaType;
use Innmind\Immutable\{
    Str,
    Map
};
use Symfony\Component\HttpFoundation\{
    Request as SfRequest,
    HeaderBag,
    ServerBag,
    ParameterBag,
    FileBag
};

final class SymfonyTranslator
{
    private $headerFactory;

    public function __construct(HeaderFactory $headerFactory)
    {
        $this->headerFactory = $headerFactory;
    }

    public function translate(SfRequest $request): ServerRequest
    {
        $protocol = Str::of($request->server->get('SERVER_PROTOCOL'))->capture(
            '~HTTP/(?<major>\d)\.(?<minor>\d)~'
        );

        return new ServerRequest\ServerRequest(
            Url::fromString($request->getUri()),
            new Method($request->getMethod()),
            new ProtocolVersion(
                (int) (string) $protocol['major'],
                (int) (string) $protocol['minor']
            ),
            $this->translateHeaders($request->headers),
            new Stream($request->getContent(true)),
            $this->translateEnvironment($request->server),
            $this->translateCookies($request->cookies),
            $this->translateQuery($request->query),
            $this->translateForm($request->request),
            $this->translateFiles($request->files)
        );
    }

    private function translateHeaders(HeaderBag $headerBag): Headers
    {
        $map = new Map('string', Header::class);

        foreach ($headerBag as $name => $value) {
            $map = $map->put(
                $name,
                $this->headerFactory->make(
                    new Str($name),
                    new Str(implode(', ', $value))
                )
            );
        }

        return new Headers($map);
    }

    private function translateEnvironment(ServerBag $server): Environment
    {
        $map = new Map('string', 'scalar');

        foreach ($server as $key => $value) {
            if (!is_scalar($value)) {
                continue;
            }

            $map = $map->put($key, $value);
        }

        return new Environment($map);
    }

    private function translateCookies(ParameterBag $cookies): Cookies
    {
        $map = new Map('string', 'scalar');

        foreach ($cookies as $key => $value) {
            $map = $map->put($key, $value);
        }

        return new Cookies($map);
    }

    private function translateQuery(ParameterBag $query): Query
    {
        $map = new Map('string', Query\Parameter::class);

        foreach ($query as $key => $value) {
            $map = $map->put(
                $key,
                new Query\Parameter\Parameter($key, $value)
            );
        }

        return new Query($map);
    }

    private function translateForm(ParameterBag $form): Form
    {
        $map = new Map('scalar', Form\Parameter::class);

        foreach ($form as $key => $value) {
            $map = $map->put(
                $key,
                $this->buildFormParameter($key, $value)
            );
        }

        return new Form($map);
    }

    private function buildFormParameter($name, $value): Form\Parameter
    {
        if (!is_array($value)) {
            return new Form\Parameter\Parameter((string) $name, $value);
        }

        $map = new Map('scalar', Form\Parameter::class);

        foreach ($value as $key => $sub) {
            $map = $map->put(
                $key,
                $this->buildFormParameter($key, $sub)
            );
        }

        return new Form\Parameter\Parameter((string) $name, $map);
    }

    private function translateFiles(FileBag $files): Files
    {
        $map = new Map('string', File::class);

        foreach ($files as $name => $file) {
            $map = $map->put(
                $name,
                new File\File(
                    $file->getClientOriginalName(),
                    new Stream(
                        fopen($file->getPathname(), 'r')
                    ),
                    $this->buildFileStatus($file->getError()),
                    MediaType::fromString((string) $file->getClientMimeType())
                )
            );
        }

        return new Files($map);
    }

    private function buildFileStatus(int $status): Status
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
