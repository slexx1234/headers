<?php

namespace Slexx\Headers;

use Slexx\Headers\Exceptions\{
    TypeException,
    ReadonlyException
};

class Headers implements \Countable, \IteratorAggregate
{
    /**
     * @var array
     */
    protected $headers = [];

    /**
     * @var bool
     */
    protected $readonly = false;

    /**
     * @param string|array $headers
     * @return array
     * @throws TypeException
     */
    public static function parse($headers)
    {
        if (is_array($headers)) {
            $result = [];
            foreach($headers as $key => $value) {
                if (is_string($key)) {
                    $result[$key] = $value;
                } else {
                    list($name, $header) = explode(':', $value, 2);
                    $result[trim($name)] = trim($header);
                }
            }
            return $result;
        } else if (is_string($headers)) {
            return static::parse(array_diff(preg_split('/\r?\n/', $headers), ['']));
        } else {
            throw new TypeException('Аргумент $headers дожен быть строкой или массивом!');
        }
    }

    /**
     * @param string|array $headers
     * @param bool [$readonly]
     * @throws TypeException
     */
    public function __construct($headers, $readonly = false)
    {
        $this->headers = static::parse($headers);
        $this->readonly = $readonly;
    }

    /**
     * @param string $name
     * @param string $value
     * @throws ReadonlyException
     * @return void
     */
    public function set($name, $value)
    {
        if ($this->readonly) {
            throw new ReadonlyException();
        }

        $this->headers[$name] = $value;
    }

    /**
     * @param string $name
     * @throws ReadonlyException
     * @return void
     */
    public function remove($name)
    {
        if ($this->readonly) {
            throw new ReadonlyException();
        }

        unset($this->headers[$name]);
    }

    /**
     * @param string $name
     * @return bool
     */
    public function has($name)
    {
        return isset($this->headers[$name]);
    }

    /**
     * @param string $name
     * @return mixed
     */
    public function get($name) {
        return $this->has($name) ? $this->headers[$name] : null;
    }

    /**
     * @return string
     */
    public function __toString()
    {
        $result = [];
        foreach($this->headers as $name => $header) {
            $result[] = $name . ': ' . $header;
        }
        return implode("\n", $result);
    }

    /**
     * @return array
     */
    public function toArray()
    {
        return $this->headers;
    }

    /**
     * @return int
     */
    public function count()
    {
        return count($this->headers);
    }

    /**
     * @return \ArrayIterator
     */
    public function getIterator()
    {
        return new \ArrayIterator($this->headers);
    }
}

