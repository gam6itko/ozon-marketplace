<?php

use Ozon\Service\Merchants\JobsService;
use Ozon\Service\Merchants\ProductsService;
use Ozon\TokenStorage;

class ProductsServiceTest extends \PHPUnit\Framework\TestCase
{
    public function setUp()
    {
        if (empty($_SERVER['OZON_APPLICATION_ID']) || empty($_SERVER['OZON_SECRET_KEY'])) {
            throw new \LogicException('Server variable must be set: OZON_APPLICATION_ID, OZON_SECRET_KEY');
        }

        if (empty($_SERVER['OZON_PRODUCT_ID'])) {
            throw new \LogicException('Server variable must be set: OZON_PRODUCT_ID');
        }
    }

    /**
     * @covers ProductsService::getTypes()
     */
    public function testGetTypes()
    {
        $svc = self::createService();
        $types = $svc->getTypes();
        self::assertNotEmpty($types);
        self::assertArrayHasKey('ProductTypes', $types);
        self::assertArrayHasKey('ProductTypeId', $types['ProductTypes'][0]);
        self::assertArrayHasKey('Name', $types['ProductTypes'][0]);
        self::assertArrayHasKey('PathName', $types['ProductTypes'][0]);
        self::assertArrayHasKey('TemplateId', $types['ProductTypes'][0]);

        $types = $svc->getTypes(true);
        self::assertNotEmpty($types);
        self::assertArrayHasKey('ProductTypes', $types);
    }

    public function testGetOne()
    {
        $svc = self::createService();
        $result = $svc->getAll([
            \Ozon\Enum\Query\ProductsParameters::ProductId => (int)$_SERVER['OZON_PRODUCT_ID']
        ]);
        self::assertNotEmpty($result);
        self::assertArrayHasKey('Products', $result);
        self::assertCount(1, $result['Products']);
    }

    /**
     * @covers ProductsService::getAll()
     */
    public function testGetAll()
    {
        $svc = self::createService();
        $result = $svc->getAll();
        self::assertNotEmpty($result);
        self::assertArrayHasKey('Products', $result);
    }

    /**
     * @covers ProductsService::create()
     * @covers JobsService::get()
     * @covers JobsService::getLog()
     */
    public function testCreate()
    {
        $xml = <<<XML
<Description>
   <Name>TestApiProductShoes</Name>
   <Article>
      <Article>TestApiProductShoesSku</Article>
      <Model>
         <Name>Snickers</Name>
         <Brand>
            <Name>Гамбитовы тапочки</Name>
         </Brand>         
         <Age>Взрослая</Age>
         <Season />
         <Collection>Весна-лето 2018</Collection>
         <Country>Россия</Country>
         <Annotation>Лучшая обувь в мире</Annotation>
         <Comment>Я джва года ждал такую обувь</Comment>
         <Material>Натуральная кожа</Material>
         <SoleMaterial>Резина</SoleMaterial>
         <InnerMaterial>Текстиль</InnerMaterial>
         <Insole>ЭВА (вспененный полимер)</Insole>
         <HeelHeight>390</HeelHeight>
         <PlatformHeight>20</PlatformHeight>
         <LegVolume>340</LegVolume>
         <Type>Тапочки</Type>
         <Width />
         <LegHeight>390</LegHeight>
         <ExternalID>12345</ExternalID>
         <Sex>Мужской</Sex>
      </Model>
      <Color>
         <Name>Черный</Name>
         <Color>черный</Color>
      </Color>
      <Picture>http://lorempixel.com/401/401/?Rlhfosexek</Picture>
      <Images>http://lorempixel.com/317/337/?Xfhtuor</Images>
      <Images>http://lorempixel.com/348/338/?Xhfdmgwmsp</Images>
      <ExternalID>12345</ExternalID>
      <Comment>Произвольный комментарий к товару.</Comment>
   </Article>
   <Size>38</Size>
</Description>
XML;

        $xml = preg_replace('/\s*\n\s*/', '', $xml);
        $json = <<<JSON
{
  "SKU": {
    "Name": "TestApiProductShoes",
    "ManufacturerIdentifier": "652M",
    "GrossWeight": "861",
    "InternalName": "Внутреннее складское наименование товара"
  },
  "Price": {
    "SellingPrice": "5600",
    "Discount": "20"
  },
  "Availability": {
    "SupplyPeriod": "In10Days",
    "Qty": "10",
    "SellingState": "ForSale"
  },
  "Description": "$xml",
  "MerchantSKU": "TestApiProductShoesSKU",
  "ProductTypeID": "286495584000"
}
JSON;
        $data = \GuzzleHttp\json_decode($json, true);
        /** @var ProductsService $svc */
        $svc = self::createService();
        $result = $svc->create($data);
        self::assertNotEmpty($result);
        self::assertArrayHasKey('JobId', $result);

        self::assertJob($result['JobId']);
    }

    public function testUpdate()
    {
        $xml = <<<XML
<Description>
   <Name>Название товара</Name>
   <Article>
      <Article>Артикульный номер</Article>
      <Model>
         <Name>Название модели обуви</Name>
         <Brand>
            <Name>Бренд</Name>
         </Brand>         
         <Age>Детская</Age>
         <Season />
         <Collection>Весна-лето 2011</Collection>
         <Country>Италия</Country>
         <Annotation>Подробное маркетинговое описание модели.</Annotation>
         <Comment>Произвольный комментарий к модели товара.</Comment>
         <Material>Натуральная кожа</Material>
         <SoleMaterial>Резина</SoleMaterial>
         <InnerMaterial>Текстиль</InnerMaterial>
         <Insole>ЭВА (вспененный полимер)</Insole>
         <HeelHeight>390</HeelHeight>
         <PlatformHeight>20</PlatformHeight>
         <LegVolume>340</LegVolume>
         <Type>Сапоги</Type>
         <Width/>
         <LegHeight>390</LegHeight>
         <ExternalID>Cqdikbxeyx</ExternalID>
         <Sex>Женский</Sex>
      </Model>
      <Color>
         <Name>Черный</Name>
         <Color>черный</Color>
      </Color>
      <Picture>http://lorempixel.com/401/401/?Rlhfosexek</Picture>
      <Images>http://lorempixel.com/317/337/?Xfhtuor</Images>
      <Images>http://lorempixel.com/348/338/?Xhfdmgwmsp</Images>
      <ExternalID>Идентификатор модели в системе мерчанта</ExternalID>
      <Comment>Произвольный комментарий к товару.</Comment>
   </Article>
   <Size>38</Size>
</Description>
XML;

        $xml = preg_replace('/\s*\n\s*/', '', $xml);
        $json = <<<JSON
{
  "SKU": {
    "Name": "Название товара",
    "ManufacturerIdentifier": "652M",
    "GrossWeight": "861",
    "InternalName": "Внутреннее складское наименование товара"
  },
  "Price": {
    "SellingPrice": "5600",
    "Discount": "20"
  },
  "Availability": {
    "SupplyPeriod": "In10Days",
    "Qty": "10",
    "SellingState": "ForSale"
  },
  "Description": "$xml",
  "MerchantSKU": "TestApiProductShoesSKU",
  "ProductTypeID": "286495584000"
}
JSON;

        $data = \GuzzleHttp\json_decode($json, true);
        /** @var ProductsService $svc */
        $svc = self::createService();
        $result = $svc->update($_SERVER['OZON_PRODUCT_ID'], $data);
        self::assertNotEmpty($result);
        self::assertArrayHasKey('JobId', $result);
    }

    public function testUpdateSku()
    {
        $json = <<<JSON
{
  "SKU": {
    "Name": "Название товара",
    "ManufacturerIdentifier": "652M",
    "GrossWeight": "861",
    "InternalName": "Внутреннее складское наименование товара"
  },
  "MerchantSKU": "TestApiProductShoesSKU",
  "ProductTypeID": "286495584000"
}
JSON;
        $data = \GuzzleHttp\json_decode($json, true);
        /** @var ProductsService $svc */
        $svc = self::createService();
        $result = $svc->updateSku($_SERVER['OZON_PRODUCT_ID'], $data);
        self::assertNotEmpty($result);
        self::assertArrayHasKey('JobId', $result);
    }

    public function testUpdateAvailability()
    {
        $json = <<<JSON
{
  "Availability": {
    "SupplyPeriod": "NotAvailable",
    "Qty": "0",
    "SellingState": "NotForSale"
  },
  "MerchantSKU": "TestApiProductShoesSKU",
  "ProductTypeID": "286495584000"
}
JSON;
        $data = \GuzzleHttp\json_decode($json, true);
        /** @var ProductsService $svc */
        $svc = self::createService();
        $result = $svc->updateAvailability($_SERVER['OZON_PRODUCT_ID'], $data);
        self::assertNotEmpty($result);
        self::assertArrayHasKey('JobId', $result);

        self::assertJob($result['JobId']);
    }

    public function testUpdatePrice()
    {
        $json = <<<JSON
{
  "Price": {
    "SellingPrice": "98765",
    "Discount": "0"
  },
  "MerchantSKU": "TestApiProductShoesSKU",
  "ProductTypeID": "286495584000"
}
JSON;
        $data = \GuzzleHttp\json_decode($json, true);
        /** @var ProductsService $svc */
        $svc = self::createService();
        $result = $svc->updatePrice($_SERVER['OZON_PRODUCT_ID'], $data);
        self::assertNotEmpty($result);
        self::assertArrayHasKey('JobId', $result);

        self::assertJob($result['JobId']);
    }

    public function testUpdateDescription()
    {
        $xml = <<<XML
<Description>
   <Name>Название товара</Name>
   <Article>
      <Article>Артикульный номер</Article>
      <Model>
         <Name>Название модели обуви</Name>
         <Brand>
            <Name>Бренд</Name>
         </Brand>         
         <Age>Детская</Age>
         <Season />
         <Collection>Весна-лето 2011</Collection>
         <Country>Италия</Country>
         <Annotation>Подробное маркетинговое описание модели.</Annotation>
         <Comment>Произвольный комментарий к модели товара.</Comment>
         <Material>Натуральная кожа</Material>
         <SoleMaterial>Резина</SoleMaterial>
         <InnerMaterial>Текстиль</InnerMaterial>
         <Insole>ЭВА (вспененный полимер)</Insole>
         <HeelHeight>390</HeelHeight>
         <PlatformHeight>20</PlatformHeight>
         <LegVolume>340</LegVolume>
         <Type>Сапоги</Type>
         <Width />
         <LegHeight>390</LegHeight>
         <ExternalID>Cqdikbxeyx</ExternalID>
         <Sex>Женский</Sex>
      </Model>
      <Color>
         <Name>Черный</Name>
         <Color>черный</Color>
      </Color>
      <Picture>http://lorempixel.com/401/401/?Rlhfosexek</Picture>
      <Images>http://lorempixel.com/317/337/?Xfhtuor</Images>
      <Images>http://lorempixel.com/348/338/?Xhfdmgwmsp</Images>
      <ExternalID>Идентификатор модели в системе мерчанта</ExternalID>
      <Comment>Произвольный комментарий к товару.</Comment>
   </Article>
   <Size>38</Size>
</Description>
XML;

        $xml = preg_replace('/\s*\n\s*/', '', $xml);
        $json = <<<JSON
{
  "Description": "$xml",
  "MerchantSKU": "TestApiProductShoesSKU",
  "ProductTypeID": "286495584000"
}
JSON;

        $data = \GuzzleHttp\json_decode($json, true);
        /** @var ProductsService $svc */
        $svc = self::createService();
        $result = $svc->updateDescription($_SERVER['OZON_PRODUCT_ID'], $data);
        self::assertNotEmpty($result);
        self::assertArrayHasKey('JobId', $result);
    }

    protected static function createService(string $className = ProductsService::class)
    {
        $ts = new TokenStorage($_SERVER['OZON_APPLICATION_ID'], $_SERVER['OZON_SECRET_KEY']);
        return new $className($ts);
    }

    private static function assertJob(int $jobId)
    {
        /** @var JobsService $svcJob */
        $svcJob = self::createService(JobsService::class);
        $info = $svcJob->get($jobId);
        self::assertNotEmpty($info);
        self::assertArrayHasKey('JobInfo', $info);
        self::assertArrayHasKey('ProcessingInfos', $info);

        $log = $svcJob->getLog($jobId);
        self::assertNotEmpty($log);
        self::assertArrayHasKey('Logs', $log);
        return [$info, $log];
    }
}