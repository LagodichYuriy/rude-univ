<?

namespace rude;

/**
 * @category types
 */
class int
{
	/**
	 * @en Returns random int value
	 * @ru Возвращает псевдослучайное целочисленное значение
	 *
	 * @param int $min Minimum limit of the random variable
	 * @param int $max Maximum limit of the random variable
	 *
	 * @return int A random integer value between min and max
	 */
	public static function rand($min, $max)
	{
		return mt_rand($min, $max);
	}

	/**
	 * @en Check if number is odd
	 * @ru Проверяет, является ли число нечётным
	 *
	 * @param int $int Any integer
	 *
	 * $is_odd = int::is_odd(1); # bool(true)
	 * $is_odd = int::is_odd(2); # bool(false)
	 * $is_odd = int::is_odd(3); # bool(true)
	 * $is_odd = int::is_odd(4); # bool(false)
	 * $is_odd = int::is_odd(5); # bool(true)
	 * $is_odd = int::is_odd(6); # bool(false)
	 *
	 * @return bool
	 */
	public static function is_odd($int)
	{
		return (bool) ($int & 1);
	}

	/**
	 * @en Check if number is even
	 * @ru Проверяет, является ли число чётным
	 *
	 * @param int $int Any integer
	 *
	 * $is_even = int::is_even(1); # bool(false)
	 * $is_even = int::is_even(2); # bool(true)
	 * $is_even = int::is_even(3); # bool(false)
	 * $is_even = int::is_even(4); # bool(true)
	 * $is_even = int::is_even(5); # bool(false)
	 * $is_even = int::is_even(6); # bool(true)
	 *
	 * @return bool
	 */
	public static function is_even($int)
	{
		return (bool) (~$int & 1);
	}

	/**
	 * @en Decimal to binary converter
	 * @ru Конверцация целочисленного значения в представление системы счисления по основанию 2
	 *
	 * @param int $int Any integer
	 *
	 * @return string Binary representation
	 */
	public static function to_bin($int)
	{
		return decbin($int);
	}

	/**
	 * @en Decimal to hexadecimal converter
	 * @ru Конверцация целочисленного значения в представление системы счисления по основанию 16
	 *
	 * @param int $int Any integer
	 *
	 * @return string Hexadecimal representation
	 */
	public static function to_hex($int)
	{
		return dechex($int);
	}

	public static function to_roman($int)
	{
		$table = array('M' => 1000, 'CM' => 900, 'D' => 500, 'CD' => 400, 'C' => 100, 'XC' => 90, 'L' => 50, 'XL' => 40, 'X' => 10, 'IX' => 9, 'V' => 5, 'IV' => 4, 'I' => 1);

		$return = '';

		while ($int > 0)
		{
			foreach ($table as $rom => $arb)
			{
				if ($int >= $arb)
				{
					$int -= $arb;
					$return .= $rom;
					break;
				}
			}
		}

		return $return;
	}

	public static function pad($int, $length = 2, $char = '0', $type = STR_PAD_LEFT)
	{
		return str_pad($int, $length, $char, $type);
	}
}