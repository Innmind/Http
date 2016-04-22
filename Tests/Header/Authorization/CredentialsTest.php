<?php
declare(strict_types = 1);

namespace Innmind\Http\Tests\Header\Authorization;

use Innmind\Http\Header\Authorization\Credentials;

class CredentialsTest extends \PHPUnit_Framework_TestCase
{
    public function testInterface()
    {
        $c = new Credentials('Basic', 'realm');

        $this->assertSame('Basic', $c->scheme());
        $this->assertSame('realm', $c->parameter());

        new Credentials('Basic', '');
    }

    /**
     * @expectedException Innmind\Http\Exception\InvalidArgumentException
     */
    public function testThrowWhenEmptyScheme()
    {
        new Credentials('', '');
    }
}
