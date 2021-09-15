<?php

namespace common\components\janusApi;

use Throwable;

class JanusCommonException extends \Exception
{
    /** @return void  */
    public function __construct(string $message = "", int $code = 0, ?Throwable $previous = null)
    {
        Parent::__construct($message, $code);
    }
}
