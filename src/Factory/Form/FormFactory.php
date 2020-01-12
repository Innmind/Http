<?php
declare(strict_types = 1);

namespace Innmind\Http\Factory\Form;

use Innmind\Http\{
    Factory\FormFactory as FormFactoryInterface,
    Message\Form,
    Message\Form\Parameter,
};

final class FormFactory implements FormFactoryInterface
{
    public function __invoke(): Form
    {
        $forms = [];

        foreach ($_POST as $name => $value) {
            $forms[] = new Parameter(
                (string) $name,
                $value,
            );
        }

        return new Form(...$forms);
    }
}
