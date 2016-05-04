<?php
declare(strict_types = 1);

namespace Innmind\Http\Factory;

use Innmind\Http\Message\{
    FormInterface,
    Form,
    Form\ParameterInterface,
    Form\Parameter
};
use Innmind\Immutable\Map;

final class FormFactory implements FormFactoryInterface
{
    public function make(): FormInterface
    {
        $map = new Map('scalar', ParameterInterface::class);

        foreach ($_POST as $name => $value) {
            $map = $map->put(
                $name,
                $this->buildParameter($name, $value)
            );
        }

        return new Form($map);
    }

    private function buildParameter($name, $value): ParameterInterface
    {
        if (!is_array($value)) {
            return new Parameter((string) $name, $value);
        }

        $map = new Map('scalar', ParameterInterface::class);

        foreach ($value as $key => $sub) {
            $map = $map->put(
                $key,
                $this->buildParameter($key, $sub)
            );
        }

        return new Parameter((string) $name, $map);
    }
}
