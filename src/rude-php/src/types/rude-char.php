<?

namespace rude;

/**
 * @category types
 */
class char
{
	/**
	 * @en Get the first character of a string
	 * @ru Получение первого символа строки
	 *
	 * $char = char::first('Hello'); # string(1) "H"
	 *
	 * @param string $string Any string
	 *
	 * @return string mixed
	 */
	public static function first($string)
	{
		if (string::is_utf8($string))
		{
			return mb_substr($string, 0, 1, 'UTF-8');
		}

		return $string[0];
	}

	/**
	 * @en Get the last one character of a string
	 * @ru Получение последнего символа строки
	 *
	 * $char = char::last('Hello'); # string(1) "o"
	 *
	 * @param string $string Any string
	 *
	 * @return string mixed
	 */
	public static function last($string)
	{
		if (string::is_utf8($string))
		{
			return mb_substr($string, -1, null, 'UTF-8');
		}

		return substr($string, -1);
	}

	/**
	 * @en Remove first character from string
	 * @ru Удаление первого символа строки
	 *
	 * @param string $string Any string
	 *
	 * @return string
	 */
	public static function remove_first($string)
	{
		if (string::is_utf8($string))
		{
			return mb_substr($string, 1, null, 'UTF-8');
		}

		return substr($string, 1);
	}

	/**
	 * @en Remove last character from string
	 * @ru Удаление последнего символа строки
	 *
	 * $string = char::remove_last('Hello'); # string(4) "Hell"
	 *
	 * @param string $string Any string
	 *
	 * @return string
	 */
	public static function remove_last($string)
	{
		if (string::is_utf8($string))
		{
			return mb_substr($string, 0, -1, 'UTF-8');
		}

		return substr($string, 0, -1);
	}

	/**
	 * @en Get characters frequency
	 * @ru Возвращает именованный массив с указанием частоты повторения каждого символа в строке
	 *
	 * $string_ASCII = 'ASCII string example';   # string(20) "ASCII string example"
	 * $string_UTF8  = 'UTF-8 string πράδειγμα'; # string(31) "UTF-8 string πράδειγμα"
	 *
	 * $result = char::frequency($string_ASCII); # Array
	 *                                           # (
	 *                                           #     [A] => 1
	 *                                           #     [S] => 1
	 *                                           #     [C] => 1
	 *                                           #     [I] => 2
	 *                                           #     [ ] => 2
	 *                                           #     [s] => 1
	 *                                           #     [t] => 1
	 *                                           #     [r] => 1
	 *                                           #     [i] => 1
	 *                                           #     [n] => 1
	 *                                           #     [g] => 1
	 *                                           #     [e] => 2
	 *                                           #     [x] => 1
	 *                                           #     [a] => 1
	 *                                           #     [m] => 1
	 *                                           #     [p] => 1
	 *                                           #     [l] => 1
	 *                                           # )
	 *
	 * $result = char::frequency($string_UTF8);  # Array
	 *                                           # (
	 *                                           #     [U] => 1
	 *                                           #     [T] => 1
	 *                                           #     [F] => 1
	 *                                           #     [-] => 1
	 *                                           #     [8] => 1
	 *                                           #     [ ] => 2
	 *                                           #     [s] => 1
	 *                                           #     [t] => 1
	 *                                           #     [r] => 1
	 *                                           #     [i] => 1
	 *                                           #     [n] => 1
	 *                                           #     [g] => 1
	 *                                           #     [π] => 1
	 *                                           #     [ρ] => 1
	 *                                           #     [ά] => 1
	 *                                           #     [δ] => 1
	 *                                           #     [ε] => 1
	 *                                           #     [ι] => 1
	 *                                           #     [γ] => 1
	 *                                           #     [μ] => 1
	 *                                           #     [α] => 1
	 *                                           # )
	 *
	 * @param string $string Any string
	 *
	 * @return array
	 */
	public static function frequency($string)
	{
		if (string::is_utf8($string))
		{
			$length = mb_strlen($string, 'UTF-8');

			$unique = array();

			for ($i = 0; $i < $length; $i++)
			{
				$char = mb_substr($string, $i, 1, 'UTF-8');

				if (!array_key_exists($char, $unique))
				{
					$unique[$char] = 0;
				}

				$unique[$char]++;
			}

			return $unique;
		}

		return count_chars($string, 0);
	}

	/**
	 * @en Сheck for zero-terminate character (or first character in the provided string)
	 * @ru Проверяет, является ли переданный символ нуль-терминатором
	 *
	 * $is_null = char::is_null("0");  # bool(false)
	 * $is_null = char::is_null("A");  # bool(false)
	 * $is_null = char::is_null("\n"); # bool(false)
	 * $is_null = char::is_null("\0"); # bool(true)
	 *
	 * @param string $char Any string
	 *
	 * @return bool
	 */
	public static function is_null($char)
	{
		if (char::first($char) === "\0")
		{
			return true;
		}

		return false;
	}

	/**
	 * @en Check if character (or first character in the provided string) is printable: letters, digit or blank
	 * @ru Проверяет переданный символ (или первый символ, в случае если была передана строка) отображаемым: буква, цифра или пробел
	 *
	 * $is_printable = char::is_printable("A");  # bool(true)
	 * $is_printable = char::is_printable("B");  # bool(true)
	 * $is_printable = char::is_printable(" ");  # bool(true)
	 * $is_printable = char::is_printable("\0"); # bool(false)
	 *
	 * @param string $char Any string
	 * @return bool
	 */
	public static function is_printable($char)
	{
		return ctype_print(char::first($char));
	}

	/**
	 * @en Detect charset of character
	 * @ru Определяет кодировку символа
	 *
	 * @param $char
	 * @return bool
	 */
	public static function is_UTF8($char)
	{
		return string::is_utf8(char::first($char));
	}
}