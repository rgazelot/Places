<?php

namespace Places\Messenger\Exception;

use InvalidArgumentException;

class ChallengeException extends InvalidArgumentException
{
    public function __construct()
    {
        parent::__construct('The challenge cannot be resolved due to invalid arguments given.');
    }
}
