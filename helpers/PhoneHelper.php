<?php

namespace app\helpers;

class PhoneHelper
{
    public static function check($phone): bool
    {
        $phone = preg_replace('/[^0-9]/', '', $phone);

        return strlen($phone) === 11;
    }

    public static function normalize($phone): string
    {
        $phone = preg_replace('/[^0-9]/', '', $phone);

        return '8' . substr($phone, 1);
    }
}