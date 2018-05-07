<?php
namespace Ozon\Enum;

/**
 * Class SystemOrderStateMerchant
 * @package Ozon\Enum
 */
class OrderStateSysName
{
    const Created = 'ClientOrderStateMerchantCreated';
    const AwaitingPayment = 'ClientOrderStateMerchantAwaitingPayment';
    const PaymentDone = 'ClientOrderStateMerchantPaymentDone';
    const Accepted = 'ClientOrderStateMerchantAccepted';
    const Sent = 'ClientOrderStateMerchantSent';
    const Done = 'ClientOrderStateMerchantDone';
    const Canceled = 'ClientOrderStateMerchantCanceled';
}