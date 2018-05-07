<?php
namespace Ozon\Service\Merchants;

/**
 * Class ProductsService
 * @package Ozon\Service\Merchants
 * @method mixed updateSku(string $id, array $data) Изменение складской информации о товаре.
 * @method mixed updateAvailability(string $id, array $data) Изменение информации о доступности и статусе товара.
 * @method mixed updatePrice(string $id, array $data) Изменение информации о цене товара.
 * @method mixed updateDescription(string $id, array $data) Изменение информации об описании товара.
 */
class ProductsService extends AbstractMerchantsService
{
    /**
     * Получение информации о товаре или списке товаров.
     * @param array $query
     * @return array|mixed
     */
    public function getAll(array $query = [])
    {
        $options = [
            'headers' => $this->getCommonHeaders()
        ];
        $options['query'] = $this->adaptQueryParameters($query);
        return $this->request("{$this->urlPathBase}/products", $options);
    }

    /**
     * Добавление нового товара.
     * @param array $data
     * @return array|mixed
     */
    public function create(array $data)
    {
        $options = [
            'headers' => array_merge($this->getCommonHeaders(), ['Content-Type' => 'application/json']),
            'body'    => \GuzzleHttp\json_encode($data)
        ];
        return $this->request("{$this->urlPathBase}/products", $options, 'POST');
    }

    /**
     * Изменение информации о товаре.
     * @param string $id
     * @param array $data
     * @return array|mixed
     */
    public function update(string $id, array $data)
    {
        return $this->putRequest('id', $id, $data);
    }

    /**
     * @param string $name
     * @param array $arguments
     * @return array|mixed
     */
    public function __call(string $name, array $arguments)
    {
        $matches = [];
        if (preg_match('/^update(.*)$/', $name, $matches)) {
            return $this->putRequest(strtolower($matches[1]), $arguments[0], $arguments[1]);
        }
        throw new \RuntimeException("unsupported function $name");
    }

    /**
     * Список разрешенных типов товара.
     * @param bool $all Список всех товаров
     * @return array|mixed
     */
    public function getTypes(bool $all = false)
    {
        $options = ['headers' => $this->getCommonHeaders()];
        return $this->request("{$this->urlPathBase}/products/types" . ($all ? '/all' : ''), $options);
    }

    private function putRequest(string $type, string $id, array $data)
    {
        $type = strtolower($type);
        $options = [
            'headers' => array_merge($this->getCommonHeaders(), ['Content-Type' => 'application/json']),
            'body'    => \GuzzleHttp\json_encode($data)
        ];
        return $this->request("{$this->urlPathBase}/products/$type/$id", $options, 'PUT');
    }
}