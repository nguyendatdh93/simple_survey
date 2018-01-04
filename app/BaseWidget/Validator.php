<?php
/**
 * Created by PhpStorm.
 * User: nguyen-dat
 * Date: 19/11/2017
 * Time: 09:33
 */

namespace App\BaseWidget;

class Validator
{
    const TYPE_IMAGE = 'image';

    /**
     * Check null or empty array/string
     * @param $val
     * @return bool
     */
    public static function isNullOrEmpty($val)
    {
        if(is_array($val)) return !empty($val);

        return strlen(trim($val)) ? true : false;
    }
}