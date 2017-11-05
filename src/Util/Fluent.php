<?php

namespace Util;

use ArrayAccess;
use Countable;
use Illuminate\Support\Str;
use IteratorAggregate;
use JsonSerializable;
use Illuminate\Contracts\Support\Jsonable;
use Illuminate\Contracts\Support\Arrayable;
use Traversable;

class Fluent implements ArrayAccess, Arrayable, Jsonable, JsonSerializable, Countable,IteratorAggregate
{
    /**
     * All of the attributes set on the container.
     *
     * @var array
     */
    protected $attributes = [];

    public function __construct($attributes=[])
    {
        $this->attributes = $attributes;

    }

    /**
     * Get an attribute from the container.
     *
     * @param  string $key
     * @param  mixed $default
     * @return mixed
     */
    public function get($key, $default = null)
    {
        if (array_key_exists($key, $this->attributes)) {
            return $this->attributes[$key];
        }

        return value($default);
    }

    /**
     * Get the attributes from the container.
     *
     * @return array
     */
    public function getAttributes()
    {
        return $this->attributes;
    }

    /**
     * Convert the Fluent instance to an array.
     *
     * @return array
     */
    public function toArray()
    {
        return $this->attributes;
    }

    /**
     * Convert the object into something JSON serializable.
     *
     * @return array
     */
    public function jsonSerialize()
    {
        return $this->toArray();
    }

    /**
     * Convert the Fluent instance to JSON.
     *
     * @param  int $options
     * @return string
     */
    public function toJson($options = 0)
    {
        return json_encode($this->jsonSerialize(), $options);
    }

    /**
     * Determine if the given offset exists.
     *
     * @param  string $offset
     * @return bool
     */
    public function offsetExists($offset)
    {
        return isset($this->attributes[$offset]);
    }

    // /**
    //  * Get the value for a given offset.
    //  *
    //  * @param  string  $offset
    //  * @return mixed
    //  */
    // public function offsetGet($offset)
    // {
    //     return $this->get($offset);
    // }

    /**
     * Set the value at the given offset.
     *
     * @param  string $offset
     * @param  mixed $value
     * @return void
     */
    public function offsetSet($offset, $value)
    {
        if (is_null($offset)) {
            $this->attributes[] = $value;
        } elseif (is_int($offset)) {
            $this->attributes[intval($offset)] = $value;
        } else {
            $this->attributes[$offset] = $value;
        }

    }

    public function &offsetGet($offset)
    {
        if (isset($this->attributes[$offset])) {
            $returnValue = &$this->attributes[$offset]; // note the &=
        } else {
            $returnValue = null;
        }

        return $returnValue;
    }

    /**
     * Unset the value at the given offset.
     *
     * @param  string $offset
     * @return void
     */
    public function offsetUnset($offset)
    {
        unset($this->attributes[$offset]);
    }

    /**
     * Handle dynamic calls to the container to set attributes.
     *
     * @param  string $method
     * @param  array $parameters
     * @return $this
     */
    public function __call($method, $parameters)
    {
        $this->attributes[$method] = count($parameters) > 0 ? $parameters[0] : true;

        return $this;
    }

    /**
     * Dynamically retrieve the value of an attribute.
     *
     * @param  string $key
     * @return mixed
     */
    public function __get($key)
    {
        return $this->get($key);
    }

    /**
     * Dynamically set the value of an attribute.
     *
     * @param  string $key
     * @param  mixed $value
     * @return void
     */
    public function __set($key, $value)
    {
        $this->offsetSet($key, $value);
    }

    /**
     * Dynamically check if an attribute is set.
     *
     * @param  string $key
     * @return bool
     */
    public function __isset($key)
    {
        return $this->offsetExists($key);
    }

    /**
     * Dynamically unset an attribute.
     *
     * @param  string $key
     * @return void
     */
    public function __unset($key)
    {
        $this->offsetUnset($key);
    }

    public function data($data)
    {
        $this->attributes = $data;
    }

    /**
     * Merge the collection with the given items.
     *
     * @param  mixed $items
     * @return static
     */
    public function merge($items)
    {
        $this->attributes = array_merge($this->attributes, $items);
    }


    // /**
    //  * Set the value at the given offset.
    //  *
    //  * @param  string $offset
    //  * @param  mixed $value
    //  * @return void
    //  */
    // public function offsetSet($offset, $value)
    // {
    //     if (is_string($offset) && Str::contains($offset, '.')) {
    //         $this->attributes = $this->setAttributeByDot($this->attributes, $offset, $value);//
    //     } else {
    //         $this->attributes[$offset] = $value;
    //     }
    // }

    // /**
    //  * Get the value for a given offset.
    //  *
    //  * @param  string $offset
    //  * @return mixed
    //  */
    // public function offsetGet($offset)
    // {
    //     if (is_string($offset) && Str::contains($offset, '.')) {
    //         return $this->getAttributeByDot($this->attributes, $offset);//
    //     }
    //
    //     return $this->get($offset);
    // }


    //
    // /**
    //  * Get ingredient's attribute which is separated by dot
    //  * @param   mixed $ingredient
    //  * @param   string $expose
    //  * @return  mixed
    //  */
    // public function setAttributeByDot($ingredient, $expose, $value)
    // {
    //     if (is_string($expose)) {
    //         $keys = explode('.', $expose);
    //         // ['']
    //         arsort($keys);
    //         $data = array_reduce($keys, function ($carray, $item) {
    //             return [$item => $carray];
    //         }, $value);
    //
    //         return array_merge_recursive($ingredient, $data);
    //     } else {
    //         if (is_array($ingredient)) {
    //             return array_keys($ingredient, $expose);
    //         } elseif (is_object($ingredient)) {
    //             return object_get($ingredient, $expose);
    //         }
    //     }
    //
    // }
    //
    // /**
    //  * Get ingredient's attribute which is separated by dot
    //  * @param   mixed $ingredient
    //  * @param   string $expose
    //  * @return  mixed
    //  */
    // public function getAttributeByDot($ingredient, $expose)
    // {
    //     if (is_string($expose)) {
    //         $keys = explode('.', $expose);
    //         return array_reduce($keys, function ($carray, $item) {
    //             if (is_array($carray)) {
    //                 return array_get($carray, $item);
    //             } elseif (is_object($carray)) {
    //                 return object_get($carray, $item);
    //             }
    //
    //         }, $ingredient);
    //     } else {
    //         if (is_array($ingredient)) {
    //             return array_keys($ingredient, $expose);
    //         } elseif (is_object($ingredient)) {
    //             return object_get($ingredient, $expose);
    //         }
    //     }
    //
    // }

    /**
     * Count elements of an object
     * @link http://php.net/manual/en/countable.count.php
     * @return int The custom count as an integer.
     * </p>
     * <p>
     * The return value is cast to an integer.
     * @since 5.1.0
     */
    public function count()
    {
        return count($this->attributes);
    }

    /**
     * Retrieve an external iterator
     * @link http://php.net/manual/en/iteratoraggregate.getiterator.php
     * @return Traversable An instance of an object implementing <b>Iterator</b> or
     * <b>Traversable</b>
     * @since 5.0.0
     */
    public function getIterator()
    {
        return new \ArrayIterator($this->attributes);
    }
}
