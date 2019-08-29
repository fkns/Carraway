<?php

namespace App\CacheHandler;

use Symfony\Component\HttpClient\HttpClient;
use Symfony\Contracts\HttpClient\Exception;
use Symfony\Contracts\HttpClient\ResponseInterface;

/**
 * Class Fastly
 * @package App\CacheHandler
 */
class Fastly implements CacheHandlerInterface
{
    /**
     * @var string
     */
    private $fastlyServiceId;

    /**
     * @var string|null
     */
    private $fastlyKey;

    /**
     * Fastly constructor.
     * @param string|null $fastlyServiceId
     * @param string|null $fastlyKey
     */
    public function __construct(?string $fastlyServiceId = null, ?string $fastlyKey = null)
    {
        $this->fastlyKey = $fastlyKey;
        $this->fastlyServiceId = $fastlyServiceId;
    }

    /**
     * @return ResponseInterface
     * @throws Exception\TransportExceptionInterface
     */
    public function purge(): ResponseInterface
    {
        $client = HttpClient::create();
        $url = sprintf('https://api.fastly.com/service/%s/purge_all', $this->fastlyServiceId);
        $headers = [
            'Fastly-Key' => $this->fastlyKey,
        ];
        $response = $client->request('POST', $url, ['headers' => $headers]);

        return $response;
    }
}