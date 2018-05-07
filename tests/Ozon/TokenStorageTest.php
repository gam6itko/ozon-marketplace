<?php

class TokenStorageTest extends \PHPUnit\Framework\TestCase
{
    public function testSetCache()
    {
        if (empty($_SERVER['OZON_APPLICATION_ID']) || empty($_SERVER['OZON_SECRET_KEY'])) {
            throw new \LogicException('Server variable must be set: OZON_APPLICATION_ID, OZON_SECRET_KEY');
        }

        $ts = new \Ozon\TokenStorage($_SERVER['OZON_APPLICATION_ID'], $_SERVER['OZON_SECRET_KEY']);
        $token = $ts->getToken('merchants');

        self::assertNotEmpty($token);
    }
}