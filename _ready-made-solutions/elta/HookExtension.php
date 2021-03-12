<?php

namespace BulkGate\CartSms;

/**
 * @author Lukáš Piják 2021 TOPefekt s.r.o.
 * @link https://www.bulkgate.com/
 */

use BulkGate\Extensions;


class HookExtension extends Extensions\Strict implements Extensions\Hook\IExtension
{
    public function extend(Extensions\Database\IDatabase $database, Extensions\Hook\Variables $variables)
    {
        $tracking_number = $database->execute($database->prepare("SELECT `tracking_id` FROM `oc_eltacourier` WHERE `order_id` = %s", [$variables->get('order_id')]))->getRow();

        if ($tracking_number)
        {
            $variables->set('tracking_id', $tracking_number->tracking_id);
        }
    }
}
