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

final class Environment implements \Iterator, \Countable
{
    private $variables;

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
     * {@inheritdoc}
     */
    public function current()
    {
        return $this->variables->current();
    }

    /**
     * {@inheritdoc}
     */
    public function key()
    {
        return $this->variables->key();
    }

    /**
     * {@inheritdoc}
     */
    public function next()
    {
        $this->variables->next();
    }

    /**
     * {@inheritdoc}
     */
    public function rewind()
    {
        $this->variables->rewind();
    }

    /**
     * {@inheritdoc}
     */
    public function valid()
    {
        return $this->variables->valid();
    }

    /**
     * {@inheritdoc}
     */
    public function count()
    {
        return $this->variables->size();
    }
}
