<?php

namespace Inviqa\Clearpay;

use Exception;
use Traversable;

class Collection implements \ArrayAccess, \Countable, \IteratorAggregate
{
    /**
     * @var array
     */
    protected $items = [];

    /**
     * Collection constructor.
     *
     * @param mixed $items
     */
    final public function __construct($items)
    {
        $this->items = $items;
    }

    /**
     * @param mixed $items
     *
     * @return static
     */
    public static function make($items): self
    {
        return new static($items);
    }

    public function map(callable $function): self
    {
        return new static(array_map($function, $this->items));
    }

    /**
     * @inheritDoc
     */
    public function getIterator()
    {
        return new \ArrayIterator($this->items);
    }


    public function count(): int
    {
        return count($this->items);
    }

    /**
     * @param mixed $offset
     *
     * @return bool
     */
    public function offsetExists($offset)
    {
        return array_key_exists($offset, $this->items);
    }

    /**
     * @param mixed $offset
     *
     * @return mixed
     */
    public function offsetGet($offset)
    {
        return $this->items[$offset];
    }

    /**
     * @param mixed $offset
     * @param mixed $value
     */
    public function offsetSet($offset, $value): void
    {
        if ($offset === null) {
            $this->items[] = $value;
        } else {
            $this->items[$offset] = $value;
        }
    }

    /**
     * @param mixed $offset
     */
    public function offsetUnset($offset): void
    {
        unset($this->items[$offset]);
    }
}
