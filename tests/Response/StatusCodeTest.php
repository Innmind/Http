<?php
declare(strict_types = 1);

namespace Tests\Innmind\Http\Response;

use Innmind\Http\Response\StatusCode;
use PHPUnit\Framework\TestCase;
use Innmind\BlackBox\{
    PHPUnit\BlackBox,
    Set,
};

class StatusCodeTest extends TestCase
{
    use BlackBox;

    public function testInterface()
    {
        $c = StatusCode::ok;

        $this->assertSame(200, $c->toInt());
        $this->assertSame('200', $c->toString());
    }

    public function testThrowWhenInvalidStatusCode()
    {
        $this->expectException(\UnhandledMatchError::class);
        $this->expectExceptionMessage('42');

        StatusCode::of(42); //sadly
    }

    public function testReturnNothingWhenInvalidStatusCode()
    {
        $this->assertNull(StatusCode::maybe(42)->match(
            static fn($code) => $code,
            static fn() => null,
        ));
    }

    public function testOf()
    {
        foreach (StatusCode::cases() as $code) {
            $this->assertSame(
                $code->toInt(),
                StatusCode::of($code->toInt())->toInt(),
            );
        }
    }

    public function testMaybe()
    {
        foreach (StatusCode::cases() as $code) {
            $this->assertSame(
                $code->toInt(),
                StatusCode::maybe($code->toInt())->match(
                    static fn($code) => $code->toInt(),
                    static fn() => null,
                ),
            );
        }
    }

    public function testCodes()
    {
        $codes = StatusCode::cases();

        $this->assertCount(74, $codes);
    }

    public function testIsInformational()
    {
        $this->assertTrue(StatusCode::continue->informational());
        $this->assertTrue(StatusCode::switchingProtocols->informational());
        $this->assertTrue(StatusCode::processing->informational());
    }

    public function testIsSuccessful()
    {
        $this->assertTrue(StatusCode::ok->successful());
        $this->assertTrue(StatusCode::created->successful());
        $this->assertTrue(StatusCode::accepted->successful());
        $this->assertTrue(StatusCode::nonAuthoritativeInformation->successful());
        $this->assertTrue(StatusCode::noContent->successful());
        $this->assertTrue(StatusCode::resetContent->successful());
        $this->assertTrue(StatusCode::partialContent->successful());
        $this->assertTrue(StatusCode::multiStatus->successful());
        $this->assertTrue(StatusCode::alreadyReported->successful());
        $this->assertTrue(StatusCode::imUsed->successful());
    }

    public function testIsRedirection()
    {
        $this->assertTrue(StatusCode::multipleChoices->redirection());
        $this->assertTrue(StatusCode::movedPermanently->redirection());
        $this->assertTrue(StatusCode::found->redirection());
        $this->assertTrue(StatusCode::seeOther->redirection());
        $this->assertTrue(StatusCode::notModified->redirection());
        $this->assertTrue(StatusCode::useProxy->redirection());
        $this->assertTrue(StatusCode::switchProxy->redirection());
        $this->assertTrue(StatusCode::temporaryRedirect->redirection());
        $this->assertTrue(StatusCode::permanentlyRedirect->redirection());
    }

    public function testIsClientError()
    {
        $this->assertTrue(StatusCode::badRequest->clientError());
        $this->assertTrue(StatusCode::unauthorized->clientError());
        $this->assertTrue(StatusCode::paymentRequired->clientError());
        $this->assertTrue(StatusCode::forbidden->clientError());
        $this->assertTrue(StatusCode::notFound->clientError());
        $this->assertTrue(StatusCode::methodNotAllowed->clientError());
        $this->assertTrue(StatusCode::notAcceptable->clientError());
        $this->assertTrue(StatusCode::proxyAuthenticationRequired->clientError());
        $this->assertTrue(StatusCode::requestTimeout->clientError());
        $this->assertTrue(StatusCode::conflict->clientError());
        $this->assertTrue(StatusCode::gone->clientError());
        $this->assertTrue(StatusCode::lengthRequired->clientError());
        $this->assertTrue(StatusCode::preconditionFailed->clientError());
        $this->assertTrue(StatusCode::requestEntityTooLarge->clientError());
        $this->assertTrue(StatusCode::requestUriTooLong->clientError());
        $this->assertTrue(StatusCode::unsupportedMediaType->clientError());
        $this->assertTrue(StatusCode::requestedRangeNotSatisfiable->clientError());
        $this->assertTrue(StatusCode::expectationFailed->clientError());
        $this->assertTrue(StatusCode::iAmATeapot->clientError());
        $this->assertTrue(StatusCode::unprocessableEntity->clientError());
        $this->assertTrue(StatusCode::locked->clientError());
        $this->assertTrue(StatusCode::failedDependency->clientError());
        $this->assertTrue(StatusCode::reservedForWebdavAdvancedCollectionsExpiredProposal->clientError());
        $this->assertTrue(StatusCode::upgradeRequired->clientError());
        $this->assertTrue(StatusCode::preconditionRequired->clientError());
        $this->assertTrue(StatusCode::tooManyRequests->clientError());
        $this->assertTrue(StatusCode::requestHeaderFieldsTooLarge->clientError());
        $this->assertTrue(StatusCode::noResponse->clientError());
        $this->assertTrue(StatusCode::unavailableForLegalReasons->clientError());
        $this->assertTrue(StatusCode::sslCertificateError->clientError());
        $this->assertTrue(StatusCode::sslCertificateRequired->clientError());
        $this->assertTrue(StatusCode::httpRequestSentToHttpsPort->clientError());
        $this->assertTrue(StatusCode::clientClosedRequest->clientError());
    }

    public function testIsServerError()
    {
        $this->assertTrue(StatusCode::internalServerError->serverError());
        $this->assertTrue(StatusCode::notImplemented->serverError());
        $this->assertTrue(StatusCode::badGateway->serverError());
        $this->assertTrue(StatusCode::serviceUnavailable->serverError());
        $this->assertTrue(StatusCode::gatewayTimeout->serverError());
        $this->assertTrue(StatusCode::versionNotSupported->serverError());
        $this->assertTrue(StatusCode::variantAlsoNegotiatesExperimental->serverError());
        $this->assertTrue(StatusCode::insufficientStorage->serverError());
        $this->assertTrue(StatusCode::loopDetected->serverError());
        $this->assertTrue(StatusCode::notExtended->serverError());
        $this->assertTrue(StatusCode::networkAuthenticationRequired->serverError());
        $this->assertTrue(StatusCode::unknownError->serverError());
        $this->assertTrue(StatusCode::webServerIsDown->serverError());
        $this->assertTrue(StatusCode::connectionTimedOut->serverError());
        $this->assertTrue(StatusCode::originIsUnreachable->serverError());
        $this->assertTrue(StatusCode::aTimeoutOccured->serverError());
        $this->assertTrue(StatusCode::sslHandshakeFailed->serverError());
        $this->assertTrue(StatusCode::invalidSslCertificate->serverError());
        $this->assertTrue(StatusCode::railgunError->serverError());
    }
}
