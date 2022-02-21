<?php
declare(strict_types = 1);

namespace Innmind\Http\Factory\Form;

use Innmind\Http\{
    Factory\FormFactory as FormFactoryInterface,
    Message\Form,
    Message\Form\Parameter,
};

/**
 * @psalm-immutable
 */
final class FormFactory implements FormFactoryInterface
{
    /** @var array<string, string|array> */
    private array $post;

    /**
     * @param array<string, string|array> $post
     */
    public function __construct(array $post)
    {
        $this->post = $post;
    }

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
