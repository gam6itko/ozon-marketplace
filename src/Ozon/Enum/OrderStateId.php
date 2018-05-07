<?php
namespace Ozon\Enum;

/**
 * Class SystemOrderStateMerchant
 * @package Ozon\Enum
 */
class OrderStateId
{
    const Created = 1001;
    const AwaitingPayment = 1210;
    const PaymentDone = 1220;
//    const Accepted = 'ClientOrderStateMerchantAccepted';
//    const Sent = 'ClientOrderStateMerchantSent';
//    const Done = 'ClientOrderStateMerchantDone';
    const Canceled = 1100;
}