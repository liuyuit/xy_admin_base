<?php

if (!function_exists('getAgeByBirthday')) {
    /**
     * 根据生日日期计算年龄
     * @param $birthday string 8位数的生日日期， 例如 19860225
     * @return mixed
     */
    function getAgeByBirthday($birthday)
    {
        if (empty($birthday)) {
            return 0;
        }

        $birthYear = substr($birthday, 0, 4);
        $birthMonth = substr($birthday, 4, 2);
        $birthDay = substr($birthday, 6, 2);

        list($currentYear, $currentMonth, $currentDay) = explode('-', date('Y-m-d'));
        $age = $currentYear - $birthYear - 1;
        if ($currentMonth > $birthMonth || ($currentMonth == $birthMonth && $currentDay >= $birthDay)) {
            $age++;
        }

        return $age;
    }
}

if (!function_exists('isAdultAge')) {
    function isAdultAge($age)
    {
        return $age >= 18;
    }
}

if (!function_exists('isAdultBirthday')) {
    function isAdultBirthday($birthday)
    {
        $age = getAgeByBirthday($birthday);
        return isAdultAge($age);
    }
}
