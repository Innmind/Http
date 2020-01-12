<?php
declare(strict_types = 1);

namespace Innmind\Http\Factory\Form;

use Innmind\Http\{
    Factory\FormFactory as FormFactoryInterface,
    Message\Form,
    Message\Form\Parameter
};
use Innmind\Immutable\Map;

final class FormFactory implements FormFactoryInterface
{
    public function __invoke(): Form
    {
        $forms = [];

        foreach ($_POST as $name => $value) {
            $forms[] = $this->buildParameter($name, $value);
        }

        return new Form(...$forms);
    }

    private function buildParameter($name, $value): Parameter
    {
        if (!\is_array($value)) {
            return new Parameter((string) $name, $value);
        }

        $map = Map::of('scalar', Parameter::class);

        foreach ($value as $key => $sub) {
            $map = ($map)(
                $key,
                $this->buildParameter($key, $sub),
            );
        }

        return new Parameter((string) $name, $map);
    }
}
