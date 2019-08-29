<?php

namespace App\Exception;

use Symfony\Component\Config\Definition\Exception\Exception;
use Throwable;

/**
 * Class DuplicatePermalinkException
 * @package App\Exception
 */
class DuplicatePermalinkException extends Exception
{
    const MESSAGE_FORMAT = 'The Permalink: %s is duplicated.';

    /**
     * DuplicatePermalinkException constructor.
     * @param string $permalink
     * @param int $code
     * @param Throwable|null $previous
     */
    public function __construct(string $permalink, int $code = 400, Throwable $previous = null)
    {
        parent::__construct(sprintf(self::MESSAGE_FORMAT, $permalink), $code, $previous);
    }
}