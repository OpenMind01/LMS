<?php

namespace Pi;

class Constants
{
    public static function getDateFormat()
    {
        return 'm/d/Y';
    }

    public static function getTimeFormat()
    {
        return 'g:i A';
    }

    public static function getDateTimeFormat()
    {
        return 'm/d/Y g:i A';
    }

    public static function getUsergroupClientId()
    {
        return 1;
    }
}