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
     * Парсинг заголовков
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
     * @param string|array $headers - Строка заголовков или массив
     * @param bool [$readonly] - Заголовки доступны только для чтения? По умолчанию false.
     * @throws TypeException
     * @example:
     *     <?php
     *     use Slexx\Headers\Headers;
     *
     *     $headers = new Headers(getallheaders());
     *     $headers->set('Accept-Charset', 'UTF-8');
     *     $headers->remove('X-My-Custom-Header');
     *
     *     print_r((string) $headers);
     */
    public function __construct($headers, $readonly = false)
    {
        $this->headers = static::parse($headers);
        $this->readonly = $readonly;
    }

    /**
     * Устанавливает заголовак
     * @param string $name - Имя заголовка
     * @param string $value - Новый заголовок
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
     * Удаляет заголовак
     * @param string $name - Имя заголовка
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
     * Проверяет существует ли заголовок
     * @param string $name - Имя заголовка
     * @return bool
     */
    public function has($name)
    {
        return isset($this->headers[$name]);
    }

    /**
     * Получает заголовак
     * @param string $name - Имя заголовка
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

