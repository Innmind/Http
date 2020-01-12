<?php
declare(strict_types = 1);

namespace Innmind\Http\Translator\ServerRequest;

use Innmind\Http\{
    Message\ServerRequest,
    Message\Method,
    Message\Environment,
    Message\Cookies,
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
    File\Status\WriteFailed as WriteFailedStatus,
};
use Innmind\Url\{
    Url,
    Path,
};
use Innmind\Stream\Readable\Stream;
use Innmind\MediaType\MediaType;
use Innmind\Immutable\{
    Str,
    Map,
};
use Symfony\Component\HttpFoundation\{
    Request as SfRequest,
    HeaderBag,
    ServerBag,
    ParameterBag,
    FileBag,
};

final class SymfonyTranslator
{
    private HeaderFactory $headerFactory;

    public function __construct(HeaderFactory $headerFactory)
    {
        $this->headerFactory = $headerFactory;
    }

    public function __invoke(SfRequest $request): ServerRequest
    {
        $protocol = Str::of($request->server->get('SERVER_PROTOCOL'))->capture(
            '~HTTP/(?<major>\d)\.(?<minor>\d)~',
        );

        return new ServerRequest\ServerRequest(
            Url::of($request->getUri()),
            new Method($request->getMethod()),
            new ProtocolVersion(
                (int) $protocol->get('major')->toString(),
                (int) $protocol->get('minor')->toString(),
            ),
            $this->translateHeaders($request->headers),
            new Stream($request->getContent(true)),
            $this->translateEnvironment($request->server),
            $this->translateCookies($request->cookies),
            $this->translateQuery($request->query),
            $this->translateForm($request->request),
            $this->translateFiles($request->files),
        );
    }

    private function translateHeaders(HeaderBag $headerBag): Headers
    {
        $headers = [];

        foreach ($headerBag as $name => $value) {
            $headers[] = ($this->headerFactory)(
                Str::of($name),
                Str::of(implode(', ', $value)),
            );
        }

        return new Headers(...$headers);
    }

    private function translateEnvironment(ServerBag $server): Environment
    {
        $map = Map::of('string', 'string');

        foreach ($server as $key => $value) {
            if (!\is_scalar($value)) {
                continue;
            }

            $map = ($map)($key, $value);
        }

        return new Environment($map);
    }

    private function translateCookies(ParameterBag $cookies): Cookies
    {
        $map = Map::of('string', 'string');

        foreach ($cookies as $key => $value) {
            $map = ($map)((string) $key, (string) $value);
        }

        return new Cookies($map);
    }

    private function translateQuery(ParameterBag $query): Query
    {
        $queries = [];

        foreach ($query as $key => $value) {
            $queries[] = new Query\Parameter($key, $value);
        }

        return new Query(...$queries);
    }

    private function translateForm(ParameterBag $form): Form
    {
        $forms = [];

        foreach ($form as $key => $value) {
            $forms[] = $this->buildFormParameter($key, $value);
        }

        return new Form(...$forms);
    }

    private function buildFormParameter($name, $value): Form\Parameter
    {
        if (!\is_array($value)) {
            return new Form\Parameter((string) $name, $value);
        }

        $map = Map::of('scalar', Form\Parameter::class);

        foreach ($value as $key => $sub) {
            $map = ($map)(
                $key,
                $this->buildFormParameter($key, $sub),
            );
        }

        return new Form\Parameter((string) $name, $map);
    }

    private function translateFiles(FileBag $files): Files
    {
        $map = [];

        foreach ($files as $name => $file) {
            $map[] = new File\File(
                $file->getClientOriginalName(),
                Stream::open(Path::of($file->getPathname())),
                $name,
                $this->buildFileStatus($file->getError()),
                MediaType::of((string) $file->getClientMimeType()),
            );
        }

        return new Files(...$map);
    }

    private function buildFileStatus(int $status): Status
    {
        switch ($status) {
            case \UPLOAD_ERR_FORM_SIZE:
                return new ExceedsFormMaxFileSizeStatus;
            case \UPLOAD_ERR_INI_SIZE:
                return new ExceedsIniMaxFileSizeStatus;
            case \UPLOAD_ERR_NO_TMP_DIR:
                return new NoTemporaryDirectoryStatus;
            case \UPLOAD_ERR_NO_FILE:
                return new NotUploadedStatus;
            case \UPLOAD_ERR_OK:
                return new OkStatus;
            case \UPLOAD_ERR_PARTIAL:
                return new PartiallyUploadedStatus;
            case \UPLOAD_ERR_EXTENSION:
                return new StoppedByExtensionStatus;
            case \UPLOAD_ERR_CANT_WRITE:
                return new WriteFailedStatus;
        }
    }
}
