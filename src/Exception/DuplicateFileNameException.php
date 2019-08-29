<?php

namespace App\Exception;

use Symfony\Component\Config\Definition\Exception\Exception;
use Throwable;

/**
 * Class DuplicateFileNameException
 * @package App\Exception
 */
class DuplicateFileNameException extends Exception
{
    /**
     * DuplicateFileNameException constructor.
     * @param string $message
     * @param int $code
     * @param Throwable|null $previous
     */
    public function __construct($message = "The file name is duplicated.", $code = 400, Throwable $previous = null)
    {
        parent::__construct($message, $code, $previous);
    }
}