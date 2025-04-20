<?php
declare(strict_types = 1);

namespace Innmind\Http\Factory\Form;

use Innmind\Http\ServerRequest\Form;

/**
 * @internal
 * @psalm-immutable
 */
final class Native
{
    /**
     * @param array<string, string|array> $post
     */
    private function __construct(
        private array $post,
    ) {
    }

    public function __invoke(): Form
    {
        return Form::of($this->post);
    }

    public static function new(): self
    {
        /** @var array<string, string|array> */
        $post = $_POST;

        return new self($post);
    }
}
