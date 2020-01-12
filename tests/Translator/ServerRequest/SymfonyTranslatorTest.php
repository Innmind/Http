<?php
declare(strict_types = 1);

namespace Tests\Innmind\Rest\ServerBundle\Translator;

use Innmind\Http\{
    Translator\ServerRequest\SymfonyTranslator,
    Message\ServerRequest,
    File\Status\Ok,
    Factory\Header\HeaderFactory
};
use Innmind\Immutable\Map;
use Symfony\Component\HttpFoundation\Request;
use PHPUnit\Framework\TestCase;

class RequestTranslatorTest extends TestCase
{
    public function testTranslate()
    {
        file_put_contents('/tmp/uploaded-file', 'some data');
        $translator = new SymfonyTranslator(
            new HeaderFactory
        );

        $request = ($translator)(
            new Request(
                [
                    'search' => 'foo',
                ],
                [
                    'csrf' => 'some token',
                ],
                [],
                [
                    'sess' => 42,
                ],
                [
                    'file' => [
                        'name' => 'uploaded-file',
                        'type' => 'text/plain',
                        'tmp_name' => '/tmp/uploaded-file',
                        'error' => 0,
                        'size' => 100,
                    ],
                ],
                [
                    'SERVER_PROTOCOL' => 'HTTP/1.1',
                    'SERVER_NAME' => 'innmind',
                    'SOME_SERVER_VARIABLE' => 'value',
                    'SOME_SERVER_VARIABLE2' => 'value',
                    'ROOT' => 'value',
                    'HTTP_CONTENT_TYPE' => 'text/html',
                    'HTTP_CONTENT_LENGTH' => '0',
                    'HTTP_ETAG' => 'asdf',
                    'PHP_AUTH_USER' => 'foo',
                    'PHP_AUTH_PW' => 'bar',
                    'REQUEST_URI' => 'foo',
                    'REQUEST_METHOD' => 'PUT',
                    'SYMFONY_ENV' => 'dev',
                ],
                'some content'
            )
        );

        $this->assertInstanceOf(ServerRequest::class, $request);
        $this->assertSame('http://innmind/foo', $request->url()->toString());
        $this->assertSame('PUT', $request->method()->toString());
        $this->assertSame('1.1', $request->protocolVersion()->toString());
        $this->assertSame(6, $request->headers()->count());
        $this->assertSame(
            'content-type: text/html',
            $request->headers()->get('Content-Type')->toString(),
        );
        $this->assertSame(
            'content-length: 0',
            $request->headers()->get('Content-Length')->toString(),
        );
        $this->assertSame(
            'etag: asdf',
            $request->headers()->get('etag')->toString(),
        );
        $this->assertSame(
            'php-auth-user: foo',
            $request->headers()->get('php-auth-user')->toString(),
        );
        $this->assertSame(
            'php-auth-pw: bar',
            $request->headers()->get('php-auth-pw')->toString(),
        );
        $this->assertSame(
            'authorization: Basic '.base64_encode('foo:bar'),
            $request->headers()->get('authorization')->toString(),
        );
        $this->assertSame('some content', $request->body()->toString());
        $this->assertSame(13, $request->environment()->count());
        $this->assertSame('dev', $request->environment()->get('SYMFONY_ENV'));
        $this->assertSame(1, $request->cookies()->count());
        $this->assertSame(42, $request->cookies()->get('sess'));
        $this->assertSame(1, $request->query()->count());
        $this->assertSame('foo', $request->query()->get('search')->value());
        $this->assertSame(1, $request->form()->count());
        $this->assertSame('some token', $request->form()->get('csrf')->value());
        $this->assertSame(1, $request->files()->count());
        $file = $request->files()->get('file');
        $this->assertSame('uploaded-file', $file->name()->toString());
        $this->assertSame('some data', $file->content()->toString());
        $this->assertInstanceOf(Ok::class, $file->status());
        $this->assertSame('text/plain', $file->mediaType()->toString());
        @unlink('/tmp/uploaded-file');
    }
}
