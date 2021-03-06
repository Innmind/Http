<?php
declare(strict_types = 1);

namespace Tests\Innmind\Http\Translator\ServerRequest;

use Innmind\Http\{
    Translator\ServerRequest\Psr7Translator,
    Translator\Request\Psr7Translator as RequestTranslator,
    Factory\Header\HeaderFactory,
    Message\ServerRequest,
    Bridge\Psr7\Stream,
    File\Status\Ok
};
use Psr\Http\Message\{
    ServerRequestInterface,
    StreamInterface,
    UploadedFileInterface
};
use PHPUnit\Framework\TestCase;

class Psr7TranslatorTest extends TestCase
{
    public function testInterface()
    {
        $translator = new Psr7Translator(
            new RequestTranslator(
                new HeaderFactory
            )
        );
        $request = $this->createMock(ServerRequestInterface::class);
        $request
            ->expects($this->once())
            ->method('getUri')
            ->willReturn('/foo');
        $request
            ->expects($this->once())
            ->method('getMethod')
            ->willReturn('post');
        $request
            ->expects($this->once())
            ->method('getProtocolVersion')
            ->willReturn('1.1');
        $request
            ->expects($this->once())
            ->method('getHeaders')
            ->willReturn([
                'content-type' => ['application/json'],
            ]);
        $request
            ->expects($this->once())
            ->method('getBody')
            ->willReturn($stream = $this->createMock(StreamInterface::class));
        $stream
            ->expects($this->once())
            ->method('__toString')
            ->willReturn('content');
        $request
            ->expects($this->once())
            ->method('getServerParams')
            ->willReturn([
                'server' => 'bar',
                'bar' => new \stdClass,
            ]);
        $request
            ->expects($this->once())
            ->method('getCookieParams')
            ->willReturn([
                'cookie' => 'bar',
                'bar' => new \stdClass,
            ]);
        $request
            ->expects($this->once())
            ->method('getQueryParams')
            ->willReturn([
                'query' => 'bar',
            ]);
        $request
            ->expects($this->once())
            ->method('getParsedBody')
            ->willReturn([
                'post' => 'bar',
            ]);
        $request
            ->expects($this->once())
            ->method('getUploadedFiles')
            ->willReturn([
                'foo' => $file = $this->createMock(UploadedFileInterface::class),
            ]);
        $file
            ->method('getClientMediaType')
            ->willReturn('text/csv');
        $file
            ->expects($this->once())
            ->method('getClientFilename')
            ->willReturn('all.csv');
        $file
            ->expects($this->once())
            ->method('getStream')
            ->willReturn($this->createMock(StreamInterface::class));
        $file
            ->expects($this->once())
            ->method('getError')
            ->willReturn(\UPLOAD_ERR_OK);

        $request = ($translator)($request);

        $this->assertInstanceOf(ServerRequest::class, $request);
        $this->assertSame('/foo', $request->url()->toString());
        $this->assertSame('POST', $request->method()->toString());
        $this->assertSame('1.1', $request->protocolVersion()->toString());
        $headers = $request->headers();
        $this->assertCount(1, $headers);
        $this->assertSame(
            'content-type: application/json',
            $headers->get('content-type')->toString(),
        );
        $this->assertSame('content', $request->body()->toString());
        $this->assertCount(1, $request->environment());
        $this->assertSame('bar', $request->environment()->get('server'));
        $this->assertCount(1, $request->cookies());
        $this->assertSame('bar', $request->cookies()->get('cookie'));
        $this->assertCount(1, $request->query());
        $this->assertSame('bar', $request->query()->get('query')->value());
        $this->assertCount(1, $request->form());
        $this->assertSame('bar', $request->form()->get('post')->value());
        $this->assertCount(1, $request->files());
        $file = $request->files()->get('foo');
        $this->assertSame('all.csv', $file->name()->toString());
        $this->assertSame('text/csv', $file->mediaType()->toString());
        $this->assertInstanceOf(Ok::class, $file->status());
        $this->assertInstanceOf(Stream::class, $file->content());
    }

    public function testDefault()
    {
        $this->assertEquals(
            new Psr7Translator(RequestTranslator::default()),
            Psr7Translator::default(),
        );
    }
}
