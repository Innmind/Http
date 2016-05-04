<?php
declare(strict_types = 1);

namespace Innmind\Http\Tests\File;

use Innmind\Http\File\{
    StatusInterface,
    ExceedsFormMaxFileSizeStatus
};

class ExceedsFormMaxFileSizeStatusTest extends \PHPUnit_Framework_TestCase
{
    public function testInterface()
    {
        $s = new ExceedsFormMaxFileSizeStatus;

        $this->assertInstanceOf(StatusInterface::class, $s);
        $this->assertSame(2, $s->value());
        $this->assertSame('UPLOAD_ERR_FORM_SIZE', (string) $s);
    }
}
