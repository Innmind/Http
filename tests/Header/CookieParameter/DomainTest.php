<?php
declare(strict_types = 1);

namespace Tests\Innmind\Http\Header\CookieParameter;

use Innmind\Http\Header\SetCookie\Domain;
use Innmind\Url\Authority\Host;
use Innmind\BlackBox\PHPUnit\Framework\TestCase;

class DomainTest extends TestCase
{
    public function testInterface()
    {
        $domain = Domain::of(Host::of('localhost'));

        $this->assertSame('Domain=localhost', $domain->toParameter()->toString());
    }
}
