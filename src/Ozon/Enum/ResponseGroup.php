<?php
namespace Ozon\Enum;

final class ResponseGroup
{
    /** Складская информация */
    const SKU = 'SKU';
    /** Цена товара */
    const Price = 'Price';
    /** Расчетная доступность товара на сайте ozon.ru и свободный остаток на складе ООО Интернет Логистика */
    const FulfilmentAvailability = 'FulfilmentAvailability';
    /** Описание товара в виде XML */
    const Description = 'Description';
    /** Исходный XML с описанием товара */
    const RawDescription = 'RawDescription';
    /** Статус товара и информация о доступности на складе */
    const Availability = 'Availability';
}