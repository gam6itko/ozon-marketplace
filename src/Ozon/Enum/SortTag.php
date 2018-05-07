<?php
namespace Ozon\Enum;

final class SortTag
{
    /** Сортировать по цене товара по убыванию */
    public const DSellingPrice = 'DSellingPrice';
    /** Сортировать по цене товара по возрастанию */
    public const ASellingPrice = 'ASellingPrice';
    /** Сортировать по наименованию товара по убыванию */
    public const DName = 'DName';
    /** Сортировать по наименованию товара по возрастанию */
    public const AName = 'AName';
    /** Сортировать по наличию на складе по убыванию */
    public const DSupplyState = 'DSupplyState';
    /** Сортировать по наличию на складе по возрастанию */
    public const ASupplyState = 'ASupplyState';
    /** Сортировать по идентификатору в ИС мерчанта по убыванию */
    public const DMerchantSKU = 'DMerchantSKU';
    /** Сортировать по идентификатору в ИС мерчанта по возрастанию */
    public const AMerchantSKU = 'AMerchantSKU';
    /** Сортировать по статусу товара по убыванию */
    public const DSellingState = 'DSellingState';
    /** Сортировать по статусу товара по возрастанию */
    public const ASellingState = 'ASellingState';
    /** Сортировать по наименованию типа товара по убыванию */
    public const DProductTypeName = 'DProductTypeName';
    /** Сортировать по наименованию типа товара по возрастанию */
    public const AProductTypeName = 'AProductTypeName';
    /** Сортировать по дате создания товара по убыванию */
    public const DAddDate = 'DAddDate';
    /** Сортировать по дате создания товара по возрастанию */
    public const AAddDate = 'AAddDate';
    /** Сортировать по дате статуса описания товара по убыванию */
    public const DDescriptionOutsourceStateMoment = 'DDescriptionOutsourceStateMoment';
    /** Сортировать по дате статуса описания товара по возрастанию */
    public const ADescriptionOutsourceStateMoment = 'ADescriptionOutsourceStateMoment';
}