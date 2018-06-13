<?php
namespace Ozon\Service\Merchants;

use Ozon\Enum\OrderStateName;

/**
 * Class Merchants
 * @package Ozon
 * @see http://marketplace.ozon.ru/merchants-help
 */
class OrdersService extends AbstractMerchantsService
{
    /**
     * @return array
     */
    public function states()
    {
        $result = $this->request("{$this->urlPathBase}/orders/states", ['headers' => $this->getCommonHeaders()]);;
        return $result['OrderStates'];
    }

    /**
     * @param array $query Параметры строки запроса<br>
     * OrderNumber	        String	    Номер заказа.<br>
     * StateName	        String	    Статус заказа.<br>
     * MinOrderSum	        Decimal	    Минимальная стоимость заказа.<br>
     * MaxOrderSum	        Decimal	    Максимальная стоимость заказа.<br>
     * DeliveryVariantName	String	    Тип доставки.<br>
     * PaymentTypeName	    String	    Тип оплаты.<br>
     * MinOrderDate	        DateTime	Минимальная дата заказа.<br>
     * MaxOrderDate	        DateTime	Максимальная дата заказа.<br>
     * MinModifyDate	    DateTime	Минимальная дата изменения заказа.<br>
     * MaxModifyDate	    DateTime	Максимальная дата изменения заказа.<br>
     * ItemsOnPage	        Int32	    Количество элементов, возвращаемых на одной странице.<br>
     * PageNumber	        Int32	    Номер запрашиваемой страницы из общего результата поиска.<br>
     * SortTag	            String      Порядок сортировки результата.<br>
     *
     * @return array
     */
    public function getAll(array $query = [])
    {
        $options = [
            'headers' => $this->getCommonHeaders()
        ];
        $options['query'] = $this->adaptQueryParameters($query);
        return $this->request("{$this->urlPathBase}/orders", $options);
    }

    /**
     * Получение информации о заказе
     * @param string $id Номер заказа (Пример: 12345678-1234)
     * @return array
     */
    public function get(string $id)
    {
        $options = [
            'headers' => $this->getCommonHeaders()
        ];
        return $this->request("{$this->urlPathBase}/orders/id/$id", $options);
    }

    /**
     * Изменение статуса заказа
     * @param string $id Номер заказа (Пример: 12345678-0001)
     * @param string $stateSysName Статус заказа, на который надо изменить ClientOrderStateMerchant
     * @param string|null $cancelReason
     * @return array
     */
    public function putState(string $id, string $stateSysName, string $cancelReason = null)
    {
        $bodyArr = [
            "StateSysName" => $stateSysName,
        ];
        if ($stateSysName === OrderStateName::Canceled) {
            if (empty($cancelReason)) {
                throw new \LogicException('Cancel reason required');
            }
            $bodyArr["CancelReason"] = $cancelReason;
        }
        $options = [
            'headers' => array_merge($this->getCommonHeaders(), ['Content-Type' => 'application/json']),
            'body'    => \GuzzleHttp\json_encode($bodyArr)
        ];
        return $this->request("{$this->urlPathBase}/orders/state/$id", $options, 'PUT', false);
    }

    /**
     * Список причин аннуляции заказа
     * @param string $orderStateSysName
     * @return array
     */
    public function cancelReasons(string $orderStateSysName)
    {
        $options = [
            'headers' => $this->getCommonHeaders(),
        ];
        return $this->request("{$this->urlPathBase}/orders/cancelreasons/$orderStateSysName", $options);
    }

    //todo public function deletePosition(string $id) {}
}