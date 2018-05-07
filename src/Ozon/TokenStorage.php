<?php
namespace Ozon;

use Doctrine\Common\Cache\ArrayCache;
use Doctrine\Common\Cache\Cache;
use GuzzleHttp\Client;
use GuzzleHttp\Exception\ClientException;

class TokenStorage
{
    protected $authUrlPathBase;

    /** @var string */
    private $applicationId;

    /** @var string */
    private $secretKey;

    /** @var Cache - token cache */
    private $cache;

    /**
     * TokenStorage constructor.
     * @param string $applicationId
     * @param string $secretKey
     * @param string $urlPathBase
     */
    public function __construct(string $applicationId, string $secretKey, $urlPathBase = 'https://api.ozon.ru/auth/token')
    {
        $this->applicationId = $applicationId;
        $this->secretKey = $secretKey;
        $this->authUrlPathBase = trim($urlPathBase, '/');

        $this->setCache(new ArrayCache());
    }

    /**
     * @return string
     */
    public function getApplicationId(): string
    {
        return $this->applicationId;
    }

    /**
     * Set cache provider for storing service auth token
     * @param Cache $cache
     */
    public function setCache(Cache $cache): void
    {
        $this->cache = $cache;
    }

    /**
     * @param string $serviceName
     * @return string - auth token
     */
    public function getToken(string $serviceName)
    {
        if ($this->cache->contains($serviceName)) {
            return $this->cache->fetch($serviceName);
        }

        $jsonString = $this->fetchTokenData($serviceName);
        $tokenData = \GuzzleHttp\json_decode($jsonString, true);
        $this->cache->save($serviceName, $tokenData['token'], (int)$tokenData['expiration']);
        return $tokenData['token'];
    }

    /**
     * @param string $serviceName
     * @return string
     */
    public function refreshToken(string $serviceName)
    {
        if ($this->cache->contains($serviceName)) {
            $this->cache->delete($serviceName);
        }

        return $this->getToken($serviceName);
    }

    /**
     * @param string $serviceName
     * @return string|array
     */
    protected function fetchTokenData(string $serviceName)
    {
        $client = new Client();
        $url = "{$this->authUrlPathBase}/$serviceName";

        try {
            $response = $client->request('GET', $url, ['headers' => [
                'x-applicationid' => $this->applicationId,
                'x-sign'          => $this->buildSign($url)
            ]]);
            return $response->getBody()->getContents();
        } catch (ClientException $exc) {
            $arr = explode(PHP_EOL, $exc->getMessage());
            $responseContent = iconv('windows-1251', 'utf-8', $arr[1]);
            $data = \GuzzleHttp\json_decode($responseContent, true);
            if (false !== $data) {
                throw new ServiceException($data['responseStatus']['message'], (int)$data['responseStatus']['errorCode']);
            }
            throw new $exc;
        }
    }

    /**
     * @param $url - service
     * @return string
     */
    private function buildSign(string $url): string
    {
        $urlConf = parse_url($url);
        return hash_hmac("sha1", $urlConf['path'], $this->secretKey);
    }
}