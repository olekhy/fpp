<?php

declare(strict_types=1);

namespace Fpp;

final class DefinitionCollection
{
    /**
     * @var array
     */
    private $registry = [];

    /**
     * @var Definition[]
     */
    private $definitions = [];

    public function addDefinition(Definition $definition)
    {
        $namespace = $definition->namespace();
        $name = $definition->name();
        
        if ($this->hasDefinition($namespace, $name)) {
            throw new \InvalidArgumentException(sprintf('Duplicate definition found: %s\\%s', $namespace, $name));
        }

        $this->registry[$definition->namespace()][$definition->name()] = true;

        $this->definitions[] = $definition;
    }

    public function hasDefinition(string $namespace, string $name): bool
    {
        return isset($this->registry[$namespace][$name]);
    }

    public function merge(DefinitionCollection $collection): DefinitionCollection
    {
        foreach ($collection->definitions() as $definition) {
            
            $namespace = $definition->namespace();
            $name = $definition->name();
            
            if ($this->hasDefinition($namespace, $name())) {
                throw new \InvalidArgumentException(sprintf('Duplicate definition found: %s\\%s', $namespace, $name));
            }

            $this->registry[$namespace][$name] = true;
            $this->definitions[] = $definition;
        }

        $collection = new DefinitionCollection();
        $collection->registry = $this->registry;
        $collection->definitions = $this->definitions;

        return $collection;
    }

    /**
     * @return Definition[]
     */
    public function definitions(): array
    {
        return $this->definitions;
    }
}
