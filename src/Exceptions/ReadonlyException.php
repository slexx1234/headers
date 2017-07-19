<?php

namespace Slexx\Headers\Exceptions;

use Throwable;

class ReadonlyException extends \Exception
{
    public function __construct($code = 0, Throwable $previous = null)
    {
        parent::__construct('Заголовки доступны только для чтения!', $code, $previous);
    }
}
