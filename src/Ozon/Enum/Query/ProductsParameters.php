<?php
namespace Ozon\Enum\Query;

final class ProductsParameters
{
    /** (Int32) Номер запрашиваемой страницы из общего результата поиска. */
    const Page = 'Page';
    /** (Int32) Количество элементов, возвращаемых на одной странице. Не более 180. По умолчанию 20. */
    const ItemsOnPage = 'ItemsOnPage';
    /** (String values) Порядок сортировки результата. */
    const SortTag = 'SortTag';
    /** (String) Название необходимых групп ответа, через запятую. */
    const ResponseGroup = 'ResponseGroup';
    /** (String) Идентификатор товара (артикул) в ИС мерчанта. */
    const MerchantSku = 'MerchantSku';
    /** (Int32) Идентификатор товара в ozon.ru. */
    const ProductId = 'ProductId';
    /** (Int64) Идентификатор типа товара. */
    const ProductTypeId = 'ProductTypeId';
    /** (String) Наименование товара. */
    const Name = 'Name';
    /** (String) Статус товара. */
    const SellingState = 'SellingState';
    /** (String) Статус описания товара. */
    const DescriptionOutsourceState = 'DescriptionOutsourceState';
    /** (String) Срок поставки под заказ. */
    const SupplyPeriod = 'SupplyPeriod';
    /** (String) Признак наличия товара на складе мерчанта (устарел, оставлен для совместимости с предыдущей версией API). */
    const SupplyState = 'SupplyState';
    /** (Decimal) Минимальная цена. */
    const MinSellingPrice = 'MinSellingPrice';
    /** (Decimal) Максимальная цена. */
    const MaxSellingPrice = 'MaxSellingPrice';
    /** (Boolean) Наличие главного изображения у товара. */
    const MainPictureExists = 'MainPictureExists';
    /** (String) URL вебвитрины (при наличии нескольких вебвитрин у мерчанта). */
    const Showcase = 'Showcase';
}