<?php

namespace modava\customer\helper;

class CustomerHelper
{
    public static function GetStatus($status)
    {
        switch ($status) {
            case 1:
                return 'Hiển thị';
            case 0:
                return 'Tạm ngưng';
            default:
                return null;
        }
    }
}