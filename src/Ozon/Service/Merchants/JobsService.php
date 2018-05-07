<?php
namespace Ozon\Service\Merchants;

class JobsService extends AbstractMerchantsService
{
    /**
     * Детальная информация о состоянии обработки запроса на обработку товара/товаров с подробным описанием выполненных работ и их статусов.
     * @param string $id
     * @return array|mixed
     */
    public function get(string $id)
    {
        return $this->request("{$this->urlPathBase}/jobs/$id", ['headers' => $this->getCommonHeaders()]);
    }

    /**
     * Детальная информация об ошибках, выявленных при обработке запроса на обработку товара/товаров.
     * @param string $id
     * @return array|mixed
     */
    public function getLog(string $id)
    {
        return $this->request("{$this->urlPathBase}/jobs/$id/log", ['headers' => $this->getCommonHeaders()]);
    }
}