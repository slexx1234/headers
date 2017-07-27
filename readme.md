Headers
=========================================
[![Latest Stable Version](https://poser.pugx.org/slexx/headers/v/stable)](https://packagist.org/packages/slexx/headers) [![Total Downloads](https://poser.pugx.org/slexx/headers/downloads)](https://packagist.org/packages/slexx/headers) [![Latest Unstable Version](https://poser.pugx.org/slexx/headers/v/unstable)](https://packagist.org/packages/slexx/headers) [![License](https://poser.pugx.org/slexx/headers/license)](https://packagist.org/packages/slexx/headers)

## Установка

```
$ composer require slexx/headers
```

## Базовое использование

Класс разбивает `HTTP` заголовки на массив и предоставляет удобную обёртку для ними.

```php
$headers = new Slexx\Headers\Headers("Content-Type: image/jpeg\r\nAccept-Charset: utf-8\r\nX-My-Custom-Header: Zeke are cool");

echo $headers->get('Content-Type');
// -> image/jpeg
```

## API
### Headers::parse($headers)

**Аргументы:**

| Имя | Тип | Описание |
| --- | --- | -------- |
| `$headers` | `array`, `string` | Если передать строку она будет разбита в массив, если массив он будетнормализован |

**Возвращает:** `array` - Массив заголовков где ключ это имя заголовка.

**Пример:**
```php
use Slexx\Headers\Headers;

var_dump(Headers::parse("Content-Type: image/jpeg\r\nAccept-Charset: utf-8\r\nX-My-Custom-Header: Zeke are cool"));
var_dump(Headers::parse([
    'Content-Type: image/jpeg',
    'Accept-Charset: utf-8',
    'X-My-Custom-Header: Zeke are cool'
]));
```

### Headers->set($name, $value)

Добавляет заголовок или изменяет существующий.

**Аргументы:**

| Имя      | Тип      | Описание           |
| -------- | -------- | ------------------ |
| `$name`  | `string` | Имя заголовка      |
| `$value` | `string` | Значение заголовка |

**Возвращает:** `void`

### Headers->remove($name)

Удаляет заголовок

**Аргументы:**

| Имя      | Тип      | Описание           |
| -------- | -------- | ------------------ |
| `$name`  | `string` | Имя заголовка      |

**Возвращает:** `void`

### Headers->has($name)

Проверяет существование заголовка

**Аргументы:**

| Имя      | Тип      | Описание           |
| -------- | -------- | ------------------ |
| `$name`  | `string` | Имя заголовка      |

**Возвращает:** `boolean`

### Headers->get($name)

Возвращает значение заголовка

**Аргументы:**

| Имя      | Тип      | Описание           |
| -------- | -------- | ------------------ |
| `$name`  | `string` | Имя заголовка      |

**Возвращает:** `string|null`

### Headers->__toString()

Преобразует заголовки в строку

**Возвращает:** `string`

### Headers->toArray()

Возвращает массив заголовков

**Возвращает:** `array`

### Headers->count()

Подсщитывает колличество заголовков

**Возвращает:** `int`

### Headers->getIterator()

Позволяет перебирать заголовки в цикле `foreach`

**Возвращает:** `ArrayIterator`

**Пример:**
```php
$headers = new Headers([
    'Content-Type: image/jpeg',
    'Accept-Charset: utf-8',
    'X-My-Custom-Header: Zeke are cool'
]);
foreach($headers as $name => $value) {
    echo "$name: $value\r\n";
}
```
