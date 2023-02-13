<?php

namespace TekBaseAPI\Exception;

class ParameterException extends \InvalidArgumentException
{
    public function __construct()
    {
        parent::__construct('Invalid Argument', 0, null);
    }
}
