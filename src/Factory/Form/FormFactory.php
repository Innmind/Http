<?php
declare(strict_types = 1);

namespace Innmind\Http\Factory\Form;

use Innmind\Http\{
    Factory\FormFactory as FormFactoryInterface,
    ServerRequest\Form,
};

/**
 * @psalm-immutable
 */
final class FormFactory implements FormFactoryInterface
{
    /**
     * @param array<string, string|array> $post
     */
    public function __construct(
        private array $post,
    ) {
    }

    #[\Override]
    public function __invoke(): Form
    {
        return Form::of($this->post);
    }

    public static function default(): self
    {
        /** @var array<string, string|array> */
        $post = $_POST;

        return new self($post);
    }
}
