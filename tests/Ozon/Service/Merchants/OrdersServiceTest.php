<?php

use Ozon\Enum\Query\OrdersParameter;
use Ozon\Service\Merchants\OrdersService;
use Ozon\TokenStorage;

class OrdersServiceTest extends \PHPUnit\Framework\TestCase
{
    public function setUp()
    {
        if (empty($_SERVER['OZON_APPLICATION_ID']) || empty($_SERVER['OZON_SECRET_KEY'])) {
            throw new \LogicException('Server variable must be set: OZON_APPLICATION_ID, OZON_SECRET_KEY');
        }
    }

    /**
     * @covers OrdersService::states
     * @covers OrdersService::getAll
     */
    public function testOrdersStates()
    {
        $svc = self::getService();
        $orderStates = $svc->states();

        self::assertNotEmpty($orderStates);

        $orders = $svc->getAll();
        self::assertNotEmpty($orders);
        self::assertArrayHasKey('TotalPages', $orders);
        self::assertArrayHasKey('TotalResults', $orders);
        self::assertArrayHasKey('Orders', $orders);

        foreach ($orderStates as $os) {
            $orders = $svc->getAll([OrdersParameter::StateName => $os['Name']]);
            self::assertNotEmpty($orders);
            self::assertArrayHasKey('TotalPages', $orders);
            self::assertArrayHasKey('TotalResults', $orders);
            self::assertArrayHasKey('Orders', $orders);
        }
    }

    /**
     * @dataProvider dataFindMinOrderDate
     * @param DateTime $dtMin
     * @param DateTime $dtMax
     */
    public function testFindMinOrderDate(\DateTime $dtMin, \DateTime $dtMax)
    {
        $query = [
            OrdersParameter::MinOrderDate => $dtMin,
            OrdersParameter::MaxOrderDate => $dtMax,
        ];
        $orders = self::getService()->getAll($query);
        self::assertNotEmpty($orders);
    }

    public function dataFindMinOrderDate()
    {
        return [
            [new \DateTime('2018-04-04'), new \DateTime('2018-04-04')]
        ];
    }

    protected static function getService(): OrdersService
    {
        $ts = new TokenStorage($_SERVER['OZON_APPLICATION_ID'], $_SERVER['OZON_SECRET_KEY']);
        return new OrdersService($ts);
    }
//    public function testPutOrderState()
//    {
//        if (empty($_SERVER['OZON_TEST_ORDER'])) {
//            throw new \LogicException('Server variable must be set: OZON_TEST_ORDER');
//        }
//
//        $ts = new TokenStorage($_SERVER['OZON_APPLICATION_ID'], $_SERVER['OZON_SECRET_KEY']);
//        $svc = new Merchants($ts);
//        $resp = $svc->putOrderState($_SERVER['OZON_TEST_ORDER'], \Ozon\Enum\OrderStateSysName::Accepted);
//        self::assertNotEmpty($resp);
//    }
}