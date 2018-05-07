<?php
namespace Ozon\Service\Merchants;

class XsdService extends AbstractMerchantsService
{
    /**
     * Получение XSD уровня всего файла загрузки (без проверки структуры элемента Description).
     * @param bool $all Получение XSD уровня всего файла загрузки (без проверки структуры элемента Description), которая содержит полный список типов товара мерчанта.
     * @return array|mixed
     */
    public function getForProducts(bool $all = false)
    {
        return $this->request("{$this->urlPathBase}/xsd/products" . ($all ? '/all' : ''), ['headers' => $this->getCommonHeaders()]);
    }

    /**
     * Получение XSD для элемента Description с описанием товара. Уникален для типа товара.
     * @param int $productTypeId
     * @return array|mixed
     */
    public function getForDescription(int $productTypeId)
    {
        return $this->request("{$this->urlPathBase}/xsd/description/$productTypeId", ['headers' => $this->getCommonHeaders()]);
    }
}