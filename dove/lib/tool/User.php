<?php
declare(strict_types=1);

namespace dove\tool;
use dove\Config;
use dove\Debug;

// 对用户的操作

class User
{
    /**
     * 会员是否到期(使用日期-时间判断)
     * @return array
     */
    public static function vip_status($dueTime='1970-01-01 00:00:00',$regTime='1970-01-01 00:00:00')
    {
        return (time() > strtotime($dueTime)) ? (strtotime($dueTime)==strtotime($regTime)) ? [false,$regTime] : [false,$dueTime,$regTime] : [true,$dueTime,$regTime];
    }
}