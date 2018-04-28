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

        $request = $translator->translate(
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
        $this->assertSame('http://innmind/foo', (string) $request->url());
        $this->assertSame('PUT', (string) $request->method());
        $this->assertSame('1.1', (string) $request->protocolVersion());
        $this->assertSame(6, $request->headers()->count());
        $this->assertSame(
            'content-type : text/html',
            (string) $request->headers()->get('Content-Type')
        );
        $this->assertSame(
            'content-length : 0',
            (string) $request->headers()->get('Content-Length')
        );
        $this->assertSame(
            'etag : asdf',
            (string) $request->headers()->get('etag')
        );
        $this->assertSame(
            'php-auth-user : foo',
            (string) $request->headers()->get('php-auth-user')
        );
        $this->assertSame(
            'php-auth-pw : bar',
            (string) $request->headers()->get('php-auth-pw')
        );
        $this->assertSame(
            'authorization : Basic '.base64_encode('foo:bar'),
            (string) $request->headers()->get('authorization')
        );
        $this->assertSame('some content', (string) $request->body());
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
        $this->assertSame('uploaded-file', (string) $file->name());
        $this->assertSame('some data', (string) $file->content());
        $this->assertInstanceOf(Ok::class, $file->status());
        $this->assertSame('text/plain', (string) $file->mediaType());
        @unlink('/tmp/uploaded-file');
    }
}
