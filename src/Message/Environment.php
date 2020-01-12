<?php
declare(strict_types = 1);

namespace Innmind\Http\Message;

use Innmind\Http\Exception\EnvironmentVariableNotFound;
use Innmind\Immutable\Map;
use function Innmind\Immutable\assertMap;

final class Environment implements \Countable
{
    private Map $variables;

    public function __construct(Map $variables = null)
    {
        $variables = $variables ?? Map::of('string', 'string');

        assertMap('string', 'string', $variables, 1);

        $this->variables = $variables;
    }

    /**
     * @throws EnvironmentVariableNotFoundException
     */
    public function get(string $name): string
    {
        if (!$this->contains($name)) {
            throw new EnvironmentVariableNotFound($name);
        }

        return $this->variables->get($name);
    }

    public function contains(string $name): bool
    {
        return $this->variables->contains($name);
    }

    /**
     * @param callable(string, string): void $function
     */
    public function foreach(callable $function): void
    {
        $this->variables->foreach($function);
    }

    /**
     * @template R
     *
     * @param R $carry
     * @param callable(R, string, string): R $reducer
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
