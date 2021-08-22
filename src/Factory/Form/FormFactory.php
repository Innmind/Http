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
    /** @var array<int|string, string|array> */
    private array $post;

    /**
     * @param array<int|string, string|array> $post
     */
    public function __construct(array $post)
    {
        $this->post = $post;
    }

    public function __invoke(): Form
    {
        $forms = [];

        foreach ($this->post as $name => $value) {
            $forms[] = new Parameter((string) $name, $value);
        }

        return new Form(...$forms);
    }

    public static function default(): self
    {
        /** @var array<int|string, string|array> */
        $post = $_POST;

        return new self($post);
    }
}
