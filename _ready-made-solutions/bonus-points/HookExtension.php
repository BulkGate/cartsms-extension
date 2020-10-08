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
        $result = $database->execute('SELECT `points` FROM `' . $database->table('customer_reward') . '` WHERE `order_id` = "' . $database->escape($variables->get('order_id')) . '"');

        if ($result->getNumRows())
        {
            $row = $result->getRow();
            $variables->set('bonus_points', $row->points);
        }
    }
}
