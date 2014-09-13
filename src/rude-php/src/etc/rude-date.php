<?

namespace rude;

class date
{
	/**
	 * @en Sets the default timezone
	 * @ru Устанавливает временную зону по умолчанию
	 *
	 * $success = date::set_timezone('Europe/Minsk'); # bool(true) if success or bool(false) if failed
	 *
	 * @param $timezone
	 * @return bool
	 */
	public static function set_timezone($timezone)
	{
		return date_default_timezone_set($timezone);
	}

	public static function date($separator = '.', $custom_timestamp = null)
	{
		if ($custom_timestamp !== null)
		{
			return date('Y' . $separator . 'm' . $separator . 'd', $custom_timestamp);
		}

		return date('Y' . $separator . 'm' . $separator . 'd');
	}

	public static function time($separator = ':', $custom_timestamp = null)
	{
		if ($custom_timestamp !== null)
		{
			return date('H' . $separator . 'i' . $separator . 's', $custom_timestamp);
		}

		return date('H' . $separator . 'i' . $separator . 's');
	}

	/**
	 * @en Get current date and time ("YYYY.MM.DD HH:MM:SS")
	 * @ru Возвращает текущую дату и время в формате "ГГГГ.ММ.ДД ЧЧ:ММ:СС"
	 *
	 * $result = date::datetime();         # string(19) "2014.08.31 18:57:49"
	 * $result = date::datetime('/');      # string(19) "2014/08/31 18:57:49"
	 * $result = date::datetime('/', '-'); # string(19) "2014/08/31 18-57-49"
	 *
	 * @param string $separator_date
	 * @param string $separator_time
	 * @param int $custom_timestamp
	 *
	 * @return string
	 */
	public static function datetime($separator_date = '.', $separator_time = ':', $custom_timestamp = null)
	{
		return date::date($separator_date, $custom_timestamp) . ' ' . date::time($separator_time, $custom_timestamp);
	}

	/**
	 * @en Get current year ("YYYY")
	 *
	 * $result = date::year(); # 2014
	 *
	 * @return string
	 */
	public static function year()
	{
		return date('Y');
	}

	/**
	 * @en Get current month ("MM")
	 * @ru Возвращает порядкойвый номер текущего месяца ("ММ")
	 *
	 * $result = date::month(); # 08
	 *
	 * @return string
	 */
	public static function month()
	{
		return date('m');
	}

	/**
	 * @en Total number of days in year
	 * @ru Возвращает число дней в году
	 *
	 * $result = date::days_in_year();     # int(365) # default year is current (365 days in 2014)
	 * $result = date::days_in_year(2010); # int(365)
	 * $result = date::days_in_year(2004); # int(366)
	 * $result = date::days_in_year(1970); # int(365)
	 *
	 * @param int $year
	 *
	 * @return string
	 */
	public static function days_in_year($year = null)
	{
		if ($year === null)
		{
			$year = date::year();
		}

		return date('z', mktime(0, 0, 0, 12, 31, $year)) + 1;
	}

	/**
	 * @en Total number of days in month
	 * @ru Возвращает число дней в указанном месяце года
	 *
	 * $result = date::days_in_month();        # int(31) # default year and month are current (31 day in August of 2014)
	 * $result = date::days_in_month(2010);    # int(31) # default month is current (31 day in August of 2010)
	 * $result = date::days_in_month(1970, 4); # int(30) # 30 days in April of 1970
	 * $result = date::days_in_month(1970, 5); # int(31) # 31 day in May of 1970
	 *
	 * @param int $year
	 * @param int $month
	 *
	 * @return int
	 */
	public static function days_in_month($year = null, $month = null)
	{
		if ($year === null)
		{
			$year = date::year();
		}

		if ($month === null)
		{
			$month = date::month();
		}

		return $month == 2 ? ($year % 4 ? 28 : ($year % 100 ? 29 : ($year % 400 ? 28 : 29))) : (($month - 1) % 7 % 2 ? 30 : 31);
	}
}