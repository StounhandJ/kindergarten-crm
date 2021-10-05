<?php

namespace App\Services;

class ChangePhone
{
    public static function clear(string $phone)
    {
        if ($phone[0]=="8")
        {
            $phone[0] = "7";
        }
        return str_replace(["(", ")", " ", "-"], "", $phone);
    }
}