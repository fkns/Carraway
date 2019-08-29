<?php

namespace App\CacheHandler;

use Symfony\Contracts\HttpClient\ResponseInterface;

/**
 * Interface CacheHandlerInterface
 * @package App\CacheHandler
 */
interface CacheHandlerInterface
{
    /**
     * @return ResponseInterface
     */
    public function purge(): ResponseInterface;
}