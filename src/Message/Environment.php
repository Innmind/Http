<?php
declare(strict_types = 1);

namespace Innmind\Http\Message;

use Innmind\Http\{
    Exception\EnvironmentVariableNotFound
};
use Innmind\Immutable\{
    MapInterface,
    Map
};
use function Innmind\Immutable\assertMap;

final class Environment implements \Countable
{
    private Map $variables;

    public function __construct(MapInterface $variables = null)
    {
        $variables = $variables ?? new Map('string', 'scalar');

        assertMap('string', 'scalar', $variables, 1);

        $this->variables = $variables;
    }

    /**
     * @throws EnvironmentVariableNotFoundException
     *
     * @return mixed
     */
    public function get(string $name)
    {
        if (!$this->contains($name)) {
            throw new EnvironmentVariableNotFound;
        }

        return $this->variables->get($name);
    }

    public function contains(string $name): bool
    {
        return $this->variables->contains($name);
    }

    /**
     * @param callable(string, scalar): void $function
     */
    public function foreach(callable $function): void
    {
        $this->variables->foreach($function);
    }

    /**
     * @template R
     *
     * @param R $carry
     * @param callable(R, string, scalar): R $reducer
     *
     * @return R
     */
    public function reduce($carry, callable $reducer)
    {
        return $this->variables->reduce($carry, $reducer);
    }

    /**
     * {@inheritdoc}
     */
    public function count()
    {
        return $this->variables->size();
    }
}
