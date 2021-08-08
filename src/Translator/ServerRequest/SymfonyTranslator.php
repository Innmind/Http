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
    Exception\LogicException,
};
use Innmind\Filesystem\File\Content;
use Innmind\Url\{
    Url,
    Path,
};
use Innmind\Stream\Readable\Stream;
use Innmind\MediaType\MediaType;
use Innmind\Immutable\{
    Str,
    Map,
    Maybe,
};
use Symfony\Component\HttpFoundation\{
    Request as SfRequest,
    HeaderBag,
    ServerBag,
    ParameterBag,
    FileBag,
    File\UploadedFile,
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
        /** @psalm-suppress MixedArgument */
        $protocol = Str::of($request->server->get('SERVER_PROTOCOL'))->capture(
            '~HTTP/(?<major>\d)\.(?<minor>\d)~',
        );

        /** @psalm-suppress PossiblyInvalidArgument */
        $body = new Stream($request->getContent(true));

        return new ServerRequest\ServerRequest(
            Url::of($request->getUri()),
            new Method($request->getMethod()),
            Maybe::all($protocol->get('major'), $protocol->get('minor'))
                ->map(static fn(Str $major, Str $minor) => new ProtocolVersion(
                    (int) $major->toString(),
                    (int) $minor->toString(),
                ))
                ->match(
                    static fn($protocol) => $protocol,
                    static fn() => new ProtocolVersion(1, 1),
                ),
            $this->translateHeaders($request->headers),
            $body,
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

        /**
         * @var string $name
         * @var array<string> $value
         */
        foreach ($headerBag as $name => $value) {
            $headers[] = ($this->headerFactory)(
                Str::of($name),
                Str::of(\implode(', ', $value)),
            );
        }

        return new Headers(...$headers);
    }

    private function translateEnvironment(ServerBag $server): Environment
    {
        /** @var Map<string, string> */
        $map = Map::of();

        /**
         * @var string $key
         * @var string $value
         */
        foreach ($server as $key => $value) {
            /** @psalm-suppress RedundantCastGivenDocblockType */
            $map = ($map)((string) $key, (string) $value);
        }

        return new Environment($map);
    }

    private function translateCookies(ParameterBag $cookies): Cookies
    {
        /** @var Map<string, string> */
        $map = Map::of();

        /**
         * @var string $key
         * @var string $value
         */
        foreach ($cookies as $key => $value) {
            /** @psalm-suppress RedundantCastGivenDocblockType */
            $map = ($map)((string) $key, (string) $value);
        }

        return new Cookies($map);
    }

    private function translateQuery(ParameterBag $query): Query
    {
        $queries = [];

        /**
         * @var string $key
         * @var string|array $value
         */
        foreach ($query as $key => $value) {
            $queries[] = new Query\Parameter($key, $value);
        }

        return new Query(...$queries);
    }

    private function translateForm(ParameterBag $form): Form
    {
        $forms = [];

        /**
         * @var string $key
         * @var string|array $value
         */
        foreach ($form as $key => $value) {
            $forms[] = new Form\Parameter($key, $value);
        }

        return new Form(...$forms);
    }

    private function translateFiles(FileBag $files): Files
    {
        $map = [];

        /**
         * @var string $name
         * @var UploadedFile $file
         */
        foreach ($files as $name => $file) {
            /** @psalm-suppress RedundantCastGivenDocblockType */
            $map[] = new File\File(
                (string) $file->getClientOriginalName(),
                Content\AtPath::of(Path::of($file->getPathname())),
                $name,
                $this->buildFileStatus($file->getError()),
                Maybe::of($file->getMimeType())
                    ->flatMap(static fn($mimeType) => MediaType::of($mimeType))
                    ->match(
                        static fn($mediaType) => $mediaType,
                        static fn() => MediaType::null(),
                    ),
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

        throw new LogicException("Unknown file upload status $status");
    }
}
