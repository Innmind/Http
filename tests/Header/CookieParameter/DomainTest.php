<?php
declare(strict_types = 1);

namespace Tests\Innmind\Http\Header\CookieParameter;

use Innmind\Http\Header\{
    CookieParameter\Domain,
    Parameter
};
use Innmind\Url\Authority\Host;
use PHPUnit\Framework\TestCase;

class DomainTest extends TestCase
{
    public function testInterface()
    {
        $domain = new Domain(new Host('localhost'));

        $this->assertInstanceOf(Parameter::class, $domain);
        $this->assertSame('Domain=localhost', $domain->toString());
    }
}
