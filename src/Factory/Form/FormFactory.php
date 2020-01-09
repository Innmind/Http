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
    public function make(): Form
    {
        $forms = [];

        foreach ($_POST as $name => $value) {
            $forms[] = $this->buildParameter($name, $value);
        }

        return new Form(...$forms);
    }

    private function buildParameter($name, $value): Parameter
    {
        if (!is_array($value)) {
            return new Parameter\Parameter((string) $name, $value);
        }

        $map = new Map('scalar', Parameter::class);

        foreach ($value as $key => $sub) {
            $map = $map->put(
                $key,
                $this->buildParameter($key, $sub)
            );
        }

        return new Parameter\Parameter((string) $name, $map);
    }
}
