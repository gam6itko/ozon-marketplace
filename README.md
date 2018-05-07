# Клиентская библеотека для работы с Ozon API.

[Документация по Ozon Api](http://marketplace.ozon.ru/merchants-help)

## Примеры

 ```php
$ts = new TokenStorage($_SERVER['OZON_APPLICATION_ID'], $_SERVER['OZON_SECRET_KEY']);
$svc = new OrdersService($ts);
$query = [
    OrdersParameter::MinOrderDate => new \DateTime('2018-05-01'),
    OrdersParameter::MaxOrderDate => new \DateTime('2018-05-09'),
];
$result = $svc->getAll($query); //Формат описан в документации
 ```
 
## Тесты

Добавьте в файл phpunit.xml авторизационные данные и ID тестового товара.