<?php

namespace TekBaseAPI\Exception;

use Exception;

class AssertNotImplemented extends Exception
{
    public function __construct()
    {
        parent::__construct('This function does not exist', 0, null);
    }
}