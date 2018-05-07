<?php
namespace Ozon\Enum;

final class DescriptionOutsourceState
{
    /** Статус не задан */
    const None = 'None';
    /** Ожидает описания */
    const Waiting = 'Waiting';
    /** Описан */
    const Described = 'Described';
    /** Снят с описания */
    const Removed = 'Removed';
    /** Требуется перезаливка */
    const Redescribed = 'Redescribed';
}