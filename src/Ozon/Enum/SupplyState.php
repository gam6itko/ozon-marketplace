<?php
namespace Ozon\Enum;

final class SupplyState
{
    /** Доступен на складе */
    const InStock = 'InStock';
    /** Временно не доступен на складе */
    const TemporaryNotInStock = 'TemporaryNotInStock';
    /** Отсутствует на складе */
    const NotInStock = 'NotInStock';
}