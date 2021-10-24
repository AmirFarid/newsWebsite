<?php
/**
 * Created by PhpStorm.
 * User: amin
 * Date: 3/9/17
 * Time: 12:52 AM
 */

namespace App\Helper;


use Carbon\Carbon;

/**
 * Class GlobalHelper
 * @package Sibapp\Services
 */
class GlobalHelper
{
    /**
     * @param $input
     * @param string $mod
     * @param string $colon
     * @return mixed
     */
    public static function persianNumber($input, $mod = 'fa', $colon = '.')
    {
        $num_a = array('0', '1', '2', '3', '4', '5', '6', '7', '8', '9', '.');
        $key_a = array('۰', '۱', '۲', '۳', '۴', '۵', '۶', '۷', '۸', '۹', $colon);
        return ($mod == 'fa') ? str_replace($num_a, $key_a, $input) : str_replace($key_a, $num_a, $input);
    }

    /**
     * @param $input
     * @param string $mod
     * @param string $colon
     * @return mixed
     */
    public static function arabicNumber($input, $mod = 'ar', $colon = '.')
    {
        $num_a = array('0', '1', '2', '3', '4', '5', '6', '7', '8', '9', '.');
        $key_a = array('٠', '١', '٢', '٣', '٤', '٥', '٦', '٧', '٨', '٩', $colon);
        return ($mod == 'ar') ? str_replace($num_a, $key_a, $input) : str_replace($key_a, $num_a, $input);
    }


    /**
     * @param $input
     * @return mixed
     */
    public static function changeToEnglishDigit($input)
    {
        $en_num = array("0", "1", "2", "3", "4", "5", "6", "7", "8", "9", "0", "1", "2", "3", "4", "5", "6", "7", "8", "9");
        $fa_num = array("۰", "۱", "۲", "۳", "۴", "۵", "۶", "۷", "۸", "۹", '٠', '١', '٢', '٣', '٤', '٥', '٦', '٧', '٨', '٩');
        return str_replace($fa_num, $en_num, $input);
    }

    /**
     * @param $input
     * @param string $mod
     * @param bool $useNumbers
     * @return mixed
     */
    public static function arabicToPersian($input, $mod = 'ar', $useNumbers = false)
    {
        $characters = [
            'ك' => 'ک',
            'دِ' => 'د',
            'بِ' => 'ب',
            'زِ' => 'ز',
            'ذِ' => 'ذ',
            'شِ' => 'ش',
            'سِ' => 'س',
            'ى' => 'ی',
            'ي' => 'ی',
        ];

        $numbers = [
            '١' => '۱',
            '٢' => '۲',
            '٣' => '۳',
            '٤' => '۴',
            '٥' => '۵',
            '٦' => '۶',
            '٧' => '۷',
            '٨' => '۸',
            '٩' => '۹',
            '٠' => '۰',
        ];

        if ($useNumbers)
            $characters = array_merge($characters, $numbers);

        if ($mod == 'ar')
            return str_replace(array_keys($characters), array_values($characters), $input);
        return str_replace(array_values($characters), array_keys($characters), $input);
    }

    /**
     * @param Carbon $datetime
     * @param bool $showHour
     * @return mixed
     */
    public static function relativeDateTime(Carbon $datetime, $showHour = false)
    {
        if (Carbon::now()->subDays(3) < $datetime) {
            $diff = time() - $datetime->timestamp;
            return self::relativeDiff($diff);
        }
        $jalaliData = self::jalaliDate($datetime);
        return $showHour ? $jalaliData : explode(" ", $jalaliData)[0];
    }

    /**
     * @param int $diff
     * @return mixed
     */
    public static function relativeDiff(int $diff)
    {
        $function = function ($diff) {
            if (abs($diff) < 60) {
                return 'همین الان';
            } elseif ($diff > 0) {
                $day_diff = floor($diff / 86400);
                if ($day_diff == 0) {
                    if ($diff < 3600) return floor($diff / 60) . ' دقیقه پیش';
                    return floor($diff / 3600) . ' ساعت پیش';
                }
                if ($day_diff == 1) return 'دیروز';
                if ($day_diff == 2) return 'پریروز';
                if ($day_diff < 7) return $day_diff . ' روز پیش';
                if ($day_diff < 31) return ceil($day_diff / 7) . ' هفته پیش';
                if ($day_diff < 60) return 'ماه قبل';

            } else {
                $diff = abs($diff);
                $day_diff = floor($diff / 86400);
                if ($day_diff == 0) {
                    if ($diff < 3600) return floor($diff / 60) . ' دقیقه دیگه';
                    return floor($diff / 3600) . ' ساعت دیگه';
                }
                if ($day_diff == 1) return 'فردا';
                if ($day_diff == 2) return 'پسفردا';

                if ($day_diff < 30) return $day_diff . ' روز دیگه';
                if ($day_diff < 60) return 'یک ماه و ' . ($day_diff - 30) . ' روز دیگه';
                if ($day_diff < 365) return intval($day_diff / 30) . ' ماه و ' . ($day_diff - intval($day_diff / 30) * 30) . ' روز دیگه';
                $year = intval($day_diff / 365);
                $month = intval(($day_diff - intval($day_diff / 365) * 365) / 30);
                $day = ($day_diff - intval($day_diff / 30) * 30);
                $output = $year . ' سال ';
                if ($month > 0)
                    $output .= ' و ' . $month . ' ماه ';
                if ($day > 0)
                    $output .= ' و ' . $day . ' روز دیگه';
                return $output;
            }
        };
        return self::persianNumber($function($diff));
    }

    /**
     * @param $input
     * @return mixed
     */
    public static function convertToEnNumber($input)
    {
        $input = self::persianNumber($input, 'en');
        $input = self::arabicNumber($input, 'en');
        return $input;
    }

    /**
     * @param $money
     * @param string $price
     * @return string
     */
    public static function formatMoney($money, $price = ' تومان')
    {
        return self::formatNumber($money) . $price;
    }

    /**
     * @param int $number
     * @param bool $thousandSeparator
     * @param string $mod
     * @return mixed
     */
    public static function formatNumber(int $number, bool $thousandSeparator = true, $mod = 'fa')
    {
        return self::persianNumber(number_format($number, 0, '', $thousandSeparator ? ',' : ''), $mod);
    }

    /**
     * @param $date
     * @param string $format
     * @return mixed|string|null
     */
    public static function jalaliDate($date, $format = 'Y/n/j H:i:s')
    {
        if (is_null($date)) {
            return null;
        }
        return Jdf::convertTimestampToJalali($date, $format);
    }
}
