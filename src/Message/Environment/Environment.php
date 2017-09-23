<?php
declare(strict_types = 1);

namespace Innmind\Http\Message\Environment;

use Innmind\Http\{
    Message\Environment as EnvironmentInterface,
    Exception\EnvironmentVariableNotFound
};
use Innmind\Immutable\{
    MapInterface,
    Map
};

final class Environment implements EnvironmentInterface
{
    private $variables;

    public function __construct(MapInterface $variables = null)
    {
        $variables = $variables ?? new Map('string', 'scalar');

        if (
            (string) $variables->keyType() !== 'string' ||
            (string) $variables->valueType() !== 'scalar'
        ) {
            throw new \TypeError(
                'Argument 1 must be of type MapInterface<string, scalar>'
            );
        }

        $this->variables = $variables;
    }

    /**
     * {@inheritdoc}
     */
    public function get(string $name)
    {
        if (!$this->has($name)) {
            throw new EnvironmentVariableNotFound;
        }

        return $this->variables->get($name);
    }

    /**
     * {@inheritdoc}
     */
    public function has(string $name): bool
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
