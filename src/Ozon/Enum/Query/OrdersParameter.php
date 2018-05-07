<?php
namespace Ozon\Enum\Query;

final class OrdersParameter
{
    /** (String) Номер заказа. */
    public const OrderNumber = 'OrderNumber';
    /** (String) Статус заказа. */
    public const StateName = 'StateName';
    /** (Decimal) Минимальная стоимость заказа. */
    public const MinOrderSum = 'MinOrderSum';
    /** (Decimal) Максимальная стоимость заказа. */
    public const MaxOrderSum = 'MaxOrderSum';
    /** (String) Тип доставки. */
    public const DeliveryVariantName = 'DeliveryVariantName';
    /** (String) Тип оплаты. */
    public const PaymentTypeName = 'PaymentTypeName';
    /** (DateTime) Минимальная дата заказа. */
    public const MinOrderDate = 'MinOrderDate';
    /** (DateTime) Максимальная дата заказа. */
    public const MaxOrderDate = 'MaxOrderDate';
    /** (DateTime) Минимальная дата изменения заказа. */
    public const MinModifyDate = 'MinModifyDate';
    /** (DateTime) Максимальная дата изменения заказа. */
    public const MaxModifyDate = 'MaxModifyDate';
    /** (Int32) Количество элементов, возвращаемых на одной странице. */
    public const ItemsOnPage = 'ItemsOnPage';
    /** (Int32) Номер запрашиваемой страницы из общего результата поиска. */
    public const PageNumber = 'PageNumber';
    /** (String) values Порядок сортировки результата. */
    public const SortTag = 'SortTag';
}