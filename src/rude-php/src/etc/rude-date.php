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
	 * @param string $format
	 *
	 * @return int
	 */
	public static function days_in_year($year = null, $format = 'z')
	{
		if ($year === null)
		{
			$year = date::year();
		}

		return date($format, mktime(0, 0, 0, 12, 31, $year)) + 1;
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

	public static function weeks_in_month($year = null, $month = null)
	{
		if ($year === null)
		{
			$year = date::year();
		}

		if ($month === null)
		{
			$month = date::month();
		}


		$month_start = mktime(0, 0, 0, $month, 1, $year);                     # start of month
		$month_end = mktime(0, 0, 0, $month, date('t', $month_start), $year); # end of month

		$week_start = date('W', $month_start);                                # start of week
		$week_end = date('W', $month_end);                                    # end of week

		if ($week_end < $week_start)
		{
			return ((52 + $week_end) - $week_start) + 1;                      # month wraps
		}

		return ($week_end - $week_start) + 1;
	}

	public static function weeks_in_year($year = null)
	{
		if ($year === null)
		{
			$year = date::year();
		}

		$date = new \DateTime;
		$date->setISODate($year, 53);

		return ($date->format('W') === '53' ? 53 : 52);
	}

	public static function first_day_of_month($year = null, $month = null, $format = 'j')
	{
		if ($year === null)
		{
			$year = date::year();
		}

		if ($month === null)
		{
			$month = date::month();
		}

		return date($format, mktime(0, 0, 0, $month, 1, $year));
	}

	public static function last_day_of_month($year = null, $month = null, $format = 'j')
	{
		if ($year === null)
		{
			$year = date::year();
		}

		if ($month === null)
		{
			$month = date::month();
		}

		$month_start = mktime(0, 0, 0, $month, 1, $year);

		return date($format, mktime(0, 0, 0, $month, date('t', $month_start), $year));
	}

	public static function week()
	{
		return (int) date('W'); # fix it, 'W' is wrong
	}

	public static function first_day_of_week($year = null, $month = null, $week = null, $format = 'j')
	{
		if ($year === null)  { $year  = date::year();  }
		if ($month === null) { $month = date::month(); }
		if ($week === null)  { $week  = date::week();  }

		if ($week == 1)
		{
			return date::first_day_of_month($year, $month, $format);
		}

		if ($week > date::weeks_in_month($year, $month))
		{
			return 0;
		}

		$day_of_weak = date::day_of_week(date::first_day_of_month($year, $month, 'U'));

		$days_in_first_week = 8 - $day_of_weak;

		$day = 7 * ($week - 2) + $days_in_first_week + 1;

		return date($format, strtotime($year . '-' . $month . '-' . $day));
	}

	public static function last_day_of_week($year = null, $month = null, $week = null, $format = 'j')
	{
		if ($year === null)  { $year  = date::year();  }
		if ($month === null) { $month = date::month(); }
		if ($week === null)  { $week  = date::week();  }

		if ($week == date::weeks_in_month($year, $month))
		{
			return date::last_day_of_month($year, $month, $format);
		}

		if ($week > date::weeks_in_month($year, $month))
		{
			return 0;
		}


		return date($format, strtotime('this sunday', date::first_day_of_week($year, $month, $week, 'U')));
	}

	public static function calendar($year)
	{
		$tmp = new \stdClass();
		$tmp->id = $year;

		$year = $tmp;
		$year->total_weeks = date::weeks_in_year($year->id);
		$year->total_days = date::days_in_year($year->id);


		$year->monthes = null;

		for ($i = 1; $i <= 12; $i++)
		{
			$month = new \stdClass();
			$month->id = $i;
			$month->total_days = date::days_in_month($year->id, $month->id);
			$month->total_weeks = date::weeks_in_month($year->id, $month->id);
			$month->first_day = date::first_day_of_month($year->id, $month->id);
			$month->last_day = date::last_day_of_month($year->id, $month->id);


			$month->weeks = null;

			for ($j = 1; $j <= $month->total_weeks; $j++)
			{
				$week = new \stdClass();
				$week->id = $j;

				$week->is_first = (int) ($j === 1);
				$week->is_last = (int) ($j === $month->total_weeks);

				$week->first_day = date::first_day_of_week($year->id, $month->id, $week->id);
				$week->last_day = date::last_day_of_week($year->id, $month->id, $week->id);

				$month->weeks[$week->id] = $week;
			}

			$year->monthes[$month->id] = $month;
		}

		return $year;
	}

	public static function day_of_week($timestamp)
	{
		     if (date::is_monday   ($timestamp)) { return 1; }
		else if (date::is_tuesday  ($timestamp)) { return 2; }
		else if (date::is_wednesday($timestamp)) { return 3; }
		else if (date::is_thursday ($timestamp)) { return 4; }
		else if (date::is_friday   ($timestamp)) { return 5; }
		else if (date::is_saturday ($timestamp)) { return 6; }
		else if (date::is_sunday   ($timestamp)) { return 7; }
		else                                     { return 0; }
	}

	public static function is_monday($timestamp)    { return date('D', $timestamp) === 'Mon'; }
	public static function is_tuesday($timestamp)   { return date('D', $timestamp) === 'Tue'; }
	public static function is_wednesday($timestamp) { return date('D', $timestamp) === 'Wed'; }
	public static function is_thursday($timestamp)  { return date('D', $timestamp) === 'Thu'; }
	public static function is_friday($timestamp)    { return date('D', $timestamp) === 'Fri'; }
	public static function is_saturday($timestamp)  { return date('D', $timestamp) === 'Sat'; }
	public static function is_sunday($timestamp)    { return date('D', $timestamp) === 'Sun'; }

}