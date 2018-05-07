<?php

use Ozon\Service\Merchants\XsdService;
use Ozon\TokenStorage;

class XsdServiceTest extends \PHPUnit\Framework\TestCase
{
    public function setUp()
    {
        if (empty($_SERVER['OZON_APPLICATION_ID']) || empty($_SERVER['OZON_SECRET_KEY'])) {
            throw new \LogicException('Server variable must be set: OZON_APPLICATION_ID, OZON_SECRET_KEY');
        }
    }

    public function testGetForProducts()
    {
        /** @var XsdService $svc */
        $svc = self::createService();
        $result = $svc->getForProducts();
        self::assertNotEmpty($result);
        self::assertArrayHasKey('Xsd', $result);

        $result = $svc->getForProducts(true);
        self::assertNotEmpty($result);
        self::assertArrayHasKey('Xsd', $result);
    }

    public function testGetForDescription()
    {
        /** @var XsdService $svc */
        $svc = self::createService();
        $result = $svc->getForDescription(286495584000); //мотообувь
        self::assertNotEmpty($result);
        self::assertArrayHasKey('Xsd', $result);
    }

    protected static function createService(string $className = XsdService::class)
    {
        $ts = new TokenStorage($_SERVER['OZON_APPLICATION_ID'], $_SERVER['OZON_SECRET_KEY']);
        return new $className($ts);
    }
}