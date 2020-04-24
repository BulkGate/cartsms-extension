<?php

namespace BulkGate\CartSms;

/**
 * @author Lukáš Piják 2020 TOPefekt s.r.o.
 * @link https://www.bulkgate.com/
 */

use BulkGate\Extensions;

class HookExtension extends Extensions\Strict implements Extensions\Hook\IExtension
{
    public function extend(Extensions\Database\IDatabase $database, Extensions\Hook\Variables $variables)
    {
        $tracking_number = $database->execute($database->prepare("
            SELECT 
                `tracking_carrier`, 
                `tracking_no`,
                `tracking_url`
            FROM `{$database->table('order')}`
            WHERE `order_id` = %s 
            LIMIT 1",
            [
                $variables->get('order_id')
            ]
        ))->getRow();

        if ($tracking_number)
        {
            $variables->set('tracking_carrier', $tracking_number->tracking_carrier);
            $variables->set('tracking_no', $tracking_number->tracking_no);
            $variables->set('tracking_url', $tracking_number->tracking_url);
        }
    }
}
