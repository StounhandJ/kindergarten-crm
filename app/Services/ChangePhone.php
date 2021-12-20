<?php

namespace App\Services;

class ChangePhone
{
    public static function clear(string $phone): string
    {
        if ($phone[0]=="8")
        {
            $phone = substr($phone, 1);
            $phone = "+7".$phone;
        }
        return str_replace(["(", ")", " ", "-"], "", $phone);
    }
}
