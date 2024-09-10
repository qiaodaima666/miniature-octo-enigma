<?php

namespace Probe\Provider;

use Exception;

/**
 * @author Eugene Terentev <eugene@terentev.net>
 */
class NotImplementedException extends Exception
{
    protected $message = 'Method is not implemented in this provider';
}
