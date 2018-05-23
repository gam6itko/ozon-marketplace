<?php

namespace Ozon\Service\Merchants;

use GuzzleHttp\Client;
use GuzzleHttp\Exception\BadResponseException;
use Ozon\ServiceException;
use Ozon\TokenStorage;

abstract class AbstractMerchantsService
{
    private const SERVICE_NAME = 'merchants';

    /** @var string */
    protected $urlPathBase;

    /** @var TokenStorage */
    protected $tokenStorage;

    /**
     * MerchantsApi constructor.
     * @param TokenStorage $tokenStorage
     * @param string $urlPathBase
     */
    public function __construct(TokenStorage $tokenStorage, string $urlPathBase = 'https://api.ozon.ru/merchants')
    {
        $this->tokenStorage = $tokenStorage;
        $this->urlPathBase = trim($urlPathBase, '/');
    }

    protected function adaptQueryParameters(array $query)
    {
        return array_map(function ($value) {
            if ($value instanceof \DateTime) {
                return $value->format(\DateTime::ISO8601);
            }
            return $value;
        }, $query);
    }

    /**
     * @param $url
     * @param array $options
     * @param string $method
     * @param bool $parseJsonResponse
     * @return array|mixed
     */
    protected function request(string $url, array $options = [], string $method = 'GET', bool $parseJsonResponse = true)
    {
        try {
            $client = new Client();
            $response = $client->request($method, $url, $options);
            $responseContent = $response->getBody()->getContents();
            $responseContent = iconv('windows-1251', 'utf-8', $responseContent);
            if (true === $parseJsonResponse) {
                return \GuzzleHttp\json_decode($responseContent, true);
            }
            return $responseContent;
        } catch (BadResponseException $exc) {
            if ($exc->getResponse()->getStatusCode() === 401) {
                $this->tokenStorage->clearToken(self::SERVICE_NAME);
            }
            $this->tryToAdaptException($exc);
            throw $exc;
        }
    }

    /**
     * @return array
     */
    protected function getCommonHeaders(): array
    {
        return [
//            'Accept-Charset'  => 'utf-8',
            'X-ApplicationId' => $this->tokenStorage->getApplicationId(),
            'X-Token'         => $this->tokenStorage->getToken(self::SERVICE_NAME),
            'X-ApiVersion'    => 0.1
        ];
    }

    /**
     * @param BadResponseException $exc
     * @throws ServiceException
     */
    private function tryToAdaptException(BadResponseException $exc): void
    {
        $responseContent = iconv('windows-1251', 'utf-8', $exc->getResponse()->getBody());
        if (empty($responseContent)) {
            return;
        }

        $data = null;
        try {
            $data = \GuzzleHttp\json_decode($responseContent, true);
        } catch (\InvalidArgumentException $iae) {
            // nothing to do
        }

        if ($data) {
            throw new ServiceException($data['ResponseStatus']['Message'], $data['ResponseStatus']['ErrorCode']);
        }
    }
}