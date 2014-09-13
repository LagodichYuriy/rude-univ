<?

namespace rude;

define('RUDE_STRING_NEWLINE_WIN', chr(0xD) . chr(0xA)); # 0xD 0xA <=> CL RF <=> \r\n (Windows)
define('RUDE_STRING_NEWLINE_LIN',            chr(0xA)); #     0xA <=>    RF <=>   \n (Linux)
define('RUDE_STRING_NEWLINE_MAC', chr(0xD)           ); # 0xD     <=> CL    <=> \r   (Macintosh)

/**
 * @category types
 */
class string
{
	/**
	 * @en Random string generator
	 * @ru Генератор псевдослучайных строк
	 *
	 *
	 * # ASCII examples:
	 * $string = string::rand();  # string(32) "9qlluBJdOlYrFAWhmBEswmSdXvAmUvOQ"
	 * $string = string::rand(4); # string(4) "xgFn"
	 * $string = string::rand(8); # string(8) "ojK0Zw96"
	 *
	 *
	 * # UTF-8 example:
	 * $string = string::rand(8, 'πράδειγμα'); # string(16) "εαγρδρμδ"
	 *
	 * @param int $length Any length (32 by default)
	 * @param string $alphabet String alphabet
	 *
	 * @return string
	 */
	public static function rand($length = 32, $alphabet = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ')
	{
		$result  = '';

		$alphabet_size = string::length($alphabet);

		for ($i = 0; $i < $length; $i++)
		{
			$number = mt_rand(1, $alphabet_size);

			$result .= string::char($alphabet, $number);
		}

		return $result;
	}

	/**
	 * @en Return the string's size (bytes)
	 * @ru Возвращает размер строки (байты)
	 *
	 * @param string $string
	 *
	 * @return int
	 */
	public static function size($string)
	{
		return string::count_bytes($string);
	}

	/**
	 * @en Return the string's length (chars)
	 * @ru Возвращает длину строки (символы)
	 *
	 * $string_ASCII = 'ASCII string example';   # string(20) "ASCII string example"
	 * $string_UTF8  = 'UTF-8 string πράδειγμα'; # string(31) "UTF-8 string πράδειγμα"
	 *
	 * $result = string::length($string_ASCII); # int(20)
	 * $result = string::length($string_UTF8);  # int(22)
	 *
	 * @param string $string
	 *
	 * @return int The length of the string in characters
	 */
	public static function length($string)
	{
		if (string::is_utf8($string))
		{
			return mb_strlen($string, 'UTF-8');
		}

		return strlen($string);
	}

	/**
	 * @en Count the number of occurrences of a substring in a string
	 * @ru Считает количество подстрок в строке
	 *
	 * $string_ASCII = 'ASCII string example example';     # string(28) "ASCII string example example"
	 * $string_UTF8  = 'UTF-8 string πράδειγμα πράδειγμα'; # string(50) "UTF-8 string πράδειγμα πράδειγμα"
	 *
	 * $result = string::count($string_ASCII, 'example');  # int(2)
	 * $result = string::count($string_UTF8, 'πράδειγμα'); # int(2)
	 *
	 * @param string $string Any string
	 * @param string $substring Any substring
	 *
	 * @return int The number of substrings in the string
	 */
	public static function count($string, $substring)
	{
		if (string::is_utf8($string))
		{
			return mb_substr_count($string, $substring, 'UTF-8');
		}

		return substr_count($string, $substring);
	}

	/**
	 * @en Get the size of the string in bytes
	 * @ru Возвращает размер строки в байтах
	 *
	 * @param string $string
	 *
	 * @return int
	 */
	public static function count_bytes($string)
	{
		# strlen cannot be trusted anymore because of mbstring.func_overload

		return mb_strlen($string, '8bit');
	}

	/**
	 * @en Count characters in the string
	 * @ru Возвращает количество букв в тексте
	 *
	 * @param string $string
	 *
	 * $string_ASCII = 'ASCII string example';   # string(20) "ASCII string example"
	 * $string_UTF8  = 'UTF-8 string πράδειγμα'; # string(31) "UTF-8 string πράδειγμα"
	 *
	 * $count = string::count_chars($string_ASCII); # int(20) # Array
	 *                                                        # (
	 *                                                        #     [A] => 1
	 *                                                        #     [S] => 1
	 *                                                        #     [C] => 1
	 *                                                        #     [I] => 2
	 *                                                        #     [ ] => 2
	 *                                                        #     [s] => 1
	 *                                                        #     [t] => 1
	 *                                                        #     [r] => 1
	 *                                                        #     [i] => 1
	 *                                                        #     [n] => 1
	 *                                                        #     [g] => 1
	 *                                                        #     [e] => 2
	 *                                                        #     [x] => 1
	 *                                                        #     [a] => 1
	 *                                                        #     [m] => 1
	 *                                                        #     [p] => 1
	 *                                                        #     [l] => 1
	 *                                                        # )
	 *
	 * $count = string::count_chars($string_UTF8);  # int(22) # Array
	 *                                                        # (
	 *                                                        #     [U] => 1
	 *                                                        #     [T] => 1
	 *                                                        #     [F] => 1
	 *                                                        #     [-] => 1
	 *                                                        #     [8] => 1
	 *                                                        #     [ ] => 2
	 *                                                        #     [s] => 1
	 *                                                        #     [t] => 1
	 *                                                        #     [r] => 1
	 *                                                        #     [i] => 1
	 *                                                        #     [n] => 1
	 *                                                        #     [g] => 1
	 *                                                        #     [π] => 1
	 *                                                        #     [ρ] => 1
	 *                                                        #     [ά] => 1
	 *                                                        #     [δ] => 1
	 *                                                        #     [ε] => 1
	 *                                                        #     [ι] => 1
	 *                                                        #     [γ] => 1
	 *                                                        #     [μ] => 1
	 *                                                        #     [α] => 1
	 *                                                        # )
	 *
	 * @return int
	 */
	public static function count_chars($string)
	{
		if (string::is_utf8($string))
		{
			return mb_strlen($string, 'UTF-8');
		}

		return strlen($string);
	}

	/**
	 * @en Count unique chars in the string
	 * @ru Возвращает количество уникальных букв в строке
	 *
	 * @param string $string Any string
	 *
	 * $string_ASCII = 'ASCII string example';   # string(20) "ASCII string example"
	 * $string_UTF8  = 'UTF-8 string πράδειγμα'; # string(31) "UTF-8 string πράδειγμα"
	 *
	 * $count = string::count_chars_unique($string_ASCII); # int(17) # Array
	 *                                                               # (
	 *                                                               #     [A] => 1
	 *                                                               #     [S] => 1
	 *                                                               #     [C] => 1
	 *                                                               #     [I] => 2
	 *                                                               #     [ ] => 2
	 *                                                               #     [s] => 1
	 *                                                               #     [t] => 1
	 *                                                               #     [r] => 1
	 *                                                               #     [i] => 1
	 *                                                               #     [n] => 1
	 *                                                               #     [g] => 1
	 *                                                               #     [e] => 2
	 *                                                               #     [x] => 1
	 *                                                               #     [a] => 1
	 *                                                               #     [m] => 1
	 *                                                               #     [p] => 1
	 *                                                               #     [l] => 1
	 *                                                               # )
	 *
	 * $count = string::count_chars_unique($string_UTF8);  # int(21) # Array
	 *                                                               # (
	 *                                                               #     [U] => 1
	 *                                                               #     [T] => 1
	 *                                                               #     [F] => 1
	 *                                                               #     [-] => 1
	 *                                                               #     [8] => 1
	 *                                                               #     [ ] => 2
	 *                                                               #     [s] => 1
	 *                                                               #     [t] => 1
	 *                                                               #     [r] => 1
	 *                                                               #     [i] => 1
	 *                                                               #     [n] => 1
	 *                                                               #     [g] => 1
	 *                                                               #     [π] => 1
	 *                                                               #     [ρ] => 1
	 *                                                               #     [ά] => 1
	 *                                                               #     [δ] => 1
	 *                                                               #     [ε] => 1
	 *                                                               #     [ι] => 1
	 *                                                               #     [γ] => 1
	 *                                                               #     [μ] => 1
	 *                                                               #     [α] => 1
	 *                                                               # )
	 *
	 * @return int
	 */
	public static function count_chars_unique($string)
	{
		$result = array_unique(string::chars($string));

		return count($result);
	}

	/**
	 * @en Count words in the string
	 * @ru Возвращает количество слов в тексте
	 *
	 * @param string $string Any string
	 * @param string $charlist A list of additional characters which will be considered as 'word'
	 *
	 * $string_ASCII = 'ASCII string example';   # string(20) "ASCII string example"
	 * $string_UTF8  = 'UTF8 string πράδειγμα'; # string(31) "UTF-8 string πράδειγμα"
	 *
	 * $count = string::count_words($string_ASCII); # int(3) # Array
	 *                                                       # (
	 *                                                       #     [0] => ASCII
	 *                                                       #     [1] => string
	 *                                                       #     [2] => example
	 *                                                       # )
	 *
	 *
	 * # if you want to use this method with UTF-8 strings - you must specify language alphabet for the correct results:
	 *
	 * $alphabet = '1234567890-ΑΒΓΔΕΖΗΘΙΚΛΜΝΞΟΠΡΣΤΥΦΧΨΩαάβγδεζηθικλμνξοπρστυφχψω';
	 *
	 *
	 * $count = string::count_words($string_UTF8, $alphabet); # int(3) # Array
	 *                                                                 # (
	 *                                                                 #     [0] => UTF-8
	 *                                                                 #     [1] => string
	 *                                                                 #     [2] => πράδειγμα
	 *                                                                 # )
	 *
	 * @return int The number of words in the text
	 */
	public static function count_words($string, $charlist = null)
	{
		if (string::is_utf8($string))
		{
			return str_word_count(str_replace("\xC2\xAD",'', $string), 0, $charlist); # "\xC2\xAD" is a "SOFT HYPHEN" character
		}

		return str_word_count($string, 0, $charlist);
	}

	/**
	 * @en Count lines in the string
	 * @ru Считает строки в тексте
	 *
	 * @param string $string Any string
	 * @param string $delimiter Line delimiter
	 *
	 * $count = string::count_lines("Text\nwith\nnewlines!"); # int(2)
	 *
	 * @return int The number of lines in the text
	 */
	public static function count_lines($string, $delimiter = PHP_EOL)
	{
		return string::count($string, $delimiter);
	}

	/**
	 * @en Replace occurrences of the search string with the replacement string
	 * @ru Заменяет найденные вхождения подстроки в строке
	 *
	 * $string_ASCII = 'ASCII string example';   # string(20) "ASCII string example"
	 * $string_UTF8  = 'UTF-8 string πράδειγμα'; # string(31) "UTF-8 string πράδειγμα"
	 *
	 * $result = string::replace($string_ASCII, 'example', 'πράδειγμα'); # string(31) "ASCII string πράδειγμα"
	 * $result = string::replace($string_UTF8, 'πράδειγμα', 'example');  # string(20) "UTF-8 string example"
	 *
	 * @param string $string Any string
	 * @param string $search Any substring
	 * @param string $replace Any string
	 * @param int $count
	 *
	 * @return string
	 */
	public static function replace($string, $search, $replace, $count = null)
	{
		if ($count === null)
		{
			return string::replace_all($string, $search, $replace);
		}

		return str_replace($search, $replace, $string, $count);
	}

	/**
	 * @en Replace all occurrences of string
	 * @ru Заменяет все найденные вхождения подстроки в строке
	 *
	 * $string_ASCII = 'ASCII string example';   # string(20) "ASCII string example"
	 * $string_UTF8  = 'UTF-8 string πράδειγμα'; # string(31) "UTF-8 string πράδειγμα"
	 *
	 * $result = string::replace_all($string_ASCII, ' ', 'aaa'); # string(24) "ASCIIaaastringaaaexample"
	 * $result = string::replace_all($string_UTF8, ' ', 'άάά');  # string(41) "UTF-8άάάstringάάάπράδειγμα"
	 *
	 * @param string $string Any string
	 * @param string $search Any substring
	 * @param string $replace Any string
	 *
	 * @return string Replaced string
	 */
	public static function replace_all($string, $search, $replace)
	{
		return str_replace($search, $replace, $string);
	}

	/**
	 * @en Replace first occurrence of string
	 * @ru Заменяет первое найденное вхождение подстроки в строке
	 *
	 * $string_ASCII = 'ASCII string example';   # string(20) "ASCII string example"
	 * $string_UTF8  = 'UTF-8 string πράδειγμα'; # string(31) "UTF-8 string πράδειγμα"
	 *
	 * $result = string::replace_first($string_ASCII, ' ', 'aaa'); # string(22) "ASCIIaaastring example"
	 * $result = string::replace_first($string_UTF8, ' ', 'άάά');  # string(36) "UTF-8άάάstring πράδειγμα"
	 *
	 * @param string $string Any string
	 * @param string $search Any substring
	 * @param string $replace Any string
	 *
	 * @return string Replaced string
	 */
	public static function replace_first($string, $search, $replace)
	{
		$pos = strpos($string, $search);

		if ($pos !== false)
		{
			$string = substr_replace($string, $replace, $pos, strlen($search));
		}

		return $string;
	}

	/**
	 * @en Replace last occurrence of string
	 * @ru Заменяет последнее найденное вхождение подстроки в строке
	 *
	 * $string_ASCII = 'ASCII string example';   # string(20) "ASCII string example"
	 * $string_UTF8  = 'UTF-8 string πράδειγμα'; # string(31) "UTF-8 string πράδειγμα"
	 *
	 * $result = string::replace_last($string_ASCII, ' ', 'aaa'); # string(22) "ASCII stringaaaexample"
	 * $result = string::replace_last($string_UTF8, ' ', 'άάά');  # string(36) "UTF-8 stringάάάπράδειγμα"
	 *
	 * @param string $string Any string
	 * @param string $search Any substring
	 * @param string $replace Any string
	 * @return string
	 */
	public static function replace_last($string, $search, $replace)
	{
		$pos = strrpos($string, $search);

		if ($pos !== false)
		{
			$string = substr_replace($string, $replace, $pos, strlen($search));
		}

		return $string;
	}

	/**
	 * @en Return part of a string with a specific length in characters
	 * @ru Возвращает часть строки с указанной длиной и смещением
	 *
	 * $string_ASCII = 'ASCII string example';   # string(20) "ASCII string example"
	 * $string_UTF8  = 'UTF-8 string πράδειγμα'; # string(31) "UTF-8 string πράδειγμα"
	 *
	 * $result = string::read($string_ASCII, 5, 13); # string(5) "examp"
	 * $result = string::read($string_UTF8, 5, 13);  # string(10) "πράδε"
	 *
	 * @param string $string Any string
	 * @param int $length Substring length to read
	 * @param int $offset String offset
	 *
	 * @return string
	 */
	public static function read($string, $length, $offset = 0)
	{
		if (string::is_utf8($string))
		{
			return mb_substr($string, $offset, $length, 'UTF-8');
		}

		return substr($string, $offset, $length);
	}

	/**
	 * @en Get the substring after a specific position
	 * @ru Получение части строки, которая следует за указанным смещение в самой строке
	 *
	 * $string_ASCII = 'ASCII string example';   # string(20) "ASCII string example"
	 * $string_UTF8  = 'UTF-8 string πράδειγμα'; # string(31) "UTF-8 string πράδειγμα"
	 *
	 * $result = string::read_rest($string_ASCII, 13); # string(7) "example"
	 * $result = string::read_rest($string_UTF8, 13);  # string(18) "πράδειγμα"
	 *
	 * @param string $string Any string
	 * @param int $offset String offset
	 *
	 * @return string
	 */
	public static function read_rest($string, $offset = 0)
	{
		return string::read($string, string::length($string) - $offset, $offset);
	}

	/**
	 * @en Get the substring after a specific substring
	 * @ru Получение части строки, которая следует за указанной подстрокой
	 *
	 * $string_ASCII = 'ASCII string example';   # string(20) "ASCII string example"
	 * $string_UTF8  = 'UTF-8 string πράδειγμα'; # string(31) "UTF-8 string πράδειγμα"
	 *
	 * $result = string::read_after($string_ASCII, 'string '); # string(7) "example"
	 * $result = string::read_after($string_UTF8, 'string ');  # string(18) "πράδειγμα"
	 *
	 * @param string $string Any string
	 * @param string $substring Any substring
	 *
	 * @return string
	 */
	public static function read_after($string, $substring)
	{
		$pos = strpos($string, $substring);

		if ($pos !== false)
		{
			return string::read($string, string::length($string) - $pos, $pos + string::length($substring));
		}

		return null;
	}

	/**
	 * @en Get the substring which starts with a specific substring
	 * @ru Получение части строки, которая начинается с указанной подстроки
	 *
	 * $string_ASCII = 'ASCII string example';   # string(20) "ASCII string example"
	 * $string_UTF8  = 'UTF-8 string πράδειγμα'; # string(31) "UTF-8 string πράδειγμα"
	 *
	 * $result = string::read_from($string_ASCII, 'string'); # string(14) "string example"
	 * $result = string::read_from($string_UTF8, 'string');  # string(25) "string πράδειγμα"
	 *
	 * @param string $string Any string
	 * @param string $substring Any substring
	 *
	 * @return string
	 */
	public static function read_from($string, $substring)
	{
		$pos = strpos($string, $substring);

		if ($pos !== false)
		{
			return string::read($string, string::length($string) - $pos, $pos);
		}

		return false;
	}

	/**
	 * @en Get the substring which is located between two specific substrings
	 * @ru Получение части строки, которая расположена между двумя указанными подстроками
	 *
	 * $string_ASCII = 'ASCII string example';   # string(20) "ASCII string example"
	 * $string_UTF8  = 'UTF-8 string πράδειγμα'; # string(31) "UTF-8 string πράδειγμα"
	 *
	 * $result = string::read_between($string_ASCII, 'ex', 'le'); # string(3) "amp"
	 * $result = string::read_between($string_UTF8, 'πρ', 'μα');  # string(10) "άδειγ"
	 *
	 * $result = string::read_between($string_ASCII, 'ex', 'le', true); # string(7) "example"
	 * $result = string::read_between($string_UTF8, 'πρ', 'μα', true);  # string(18) "πράδειγμα"
	 *
	 * @param string $string
	 * @param string $substring_one
	 * @param string $substring_two
	 * @param bool $include_borders
	 *
	 * @return string
	 */
	public static function read_between($string, $substring_one, $substring_two, $include_borders = false)
	{
		$pos_one = string::find($string, $substring_one);

		if ($pos_one === false)
		{
			return null;
		}

		$pos_two = string::find($string, $substring_two, $pos_one + 1);

		if ($pos_two === false)
		{
			return null;
		}

		$size_one = string::length($substring_one);

		$substring = string::read($string, $pos_two - $pos_one - $size_one, $pos_one + $size_one);

		if ($include_borders !== false)
		{
			return $substring_one . $substring . $substring_two;
		}

		return $substring;
	}

	/**
	 * @en Split a string by substring
	 * @ru Разбивает строку с помощью подстрок
	 *
	 * $result = string::split("First line\nSecond line\nThird line"); # Array
	 *                                                                 # (
	 *                                                                 #     [0] => First line
	 *                                                                 #     [1] => Second line
	 *                                                                 #     [2] => Third line
	 *                                                                 # )
	 *
	 * $result = string::split('String Array Object', ' '); # Array
	 *                                                      # (
	 *                                                      #     [0] => String
	 *                                                      #     [1] => Array
	 *                                                      #     [2] => Object
	 *                                                      # )
	 *
	 * $result = string::split('baby,son,mom,dad', ','); # Array
	 *                                                   # (
	 *                                                   #     [0] => baby
	 *                                                   #     [1] => son
	 *                                                   #     [2] => mom
	 *                                                   #     [3] => dad
	 *                                                   # )
	 *
	 * @param string $string Any string
	 * @param string $delimiter String delimiter (newline by default)
	 * @param int $limit Limit elements
	 *
	 * @return array
	 */
	public static function explode($string, $delimiter = PHP_EOL, $limit = null)
	{
		if ($limit === null)
		{
			return explode($delimiter, $string);
		}

		return explode($delimiter, $string, $limit);
	}

	/**
	 * @en Check if a string contains the specified substing
	 * @ru Проверяет наличие подстроки в строке
	 *
	 * $string = 'Shit happens';
	 * $substring = 'hit';
	 *
	 * $is_contains = string::contains($string, $substring); # bool(true)
	 *
	 * @param string $string Any string
	 * @param string $substring Any substring
	 * @param bool $case_sensitive `true` for case sensitive search and `false` otherwise
	 * @return bool
	 */
	public static function contains($string, $substring, $case_sensitive = true)
	{
		if (string::is_utf8($string))
		{
			if ($case_sensitive !== true)
			{
				if (mb_stripos($string, $substring) === false)
				{
					return false;
				}

				return true;
			}

			if (mb_strpos($string, $substring) === false)
			{
				return false;
			}

			return true;
		}


		if ($case_sensitive !== true)
		{
			if (stripos($string, $substring) === false)
			{
				return false;
			}

			return true;
		}

		if (strpos($string, $substring) === false)
		{
			return false;
		}

		return true;
	}

	/**
	 * @en Check if a string starts with the specified character/string or not
	 * @ru Проверяет, начинается ли строка с указанной подстроки
	 *
	 * $string_ASCII = 'ASCII string example';   # string(20) "ASCII string example"
	 * $string_UTF8  = 'UTF-8 string πράδειγμα'; # string(31) "UTF-8 string πράδειγμα"
	 *
	 * $result = string::starts_with($string_ASCII, 'example');  # bool(false)
	 * $result = string::starts_with($string_ASCII, 'ASCII');    # bool(true)
	 *
	 * $result = string::starts_with($string_UTF8, 'πράδειγμα'); # bool(false)
	 * $result = string::starts_with($string_UTF8, 'UTF-8');     # bool(true)
	 *
	 * @param string $string Any string
	 * @param string $substring Any substring
	 * @return bool
	 */
	public static function starts_with($string, $substring)
	{
		return (substr($string, 0, strlen($substring)) === $substring);
	}

	/**
	 * @en Check if a string ends with the specified character/string or not
	 * @ru Проверяет, заканчивается ли строка указанной подстрокой
	 *
	 * $string_ASCII = 'ASCII string example';   # string(20) "ASCII string example"
	 * $string_UTF8  = 'UTF-8 string πράδειγμα'; # string(31) "UTF-8 string πράδειγμα"
	 *
	 * $result = string::ends_with($string_ASCII, 'example');  # bool(true)
	 * $result = string::ends_with($string_ASCII, 'ASCII');    # bool(false)
	 *
	 * $result = string::ends_with($string_UTF8, 'πράδειγμα'); # bool(true)
	 * $result = string::ends_with($string_UTF8, 'UTF-8');     # bool(false)
	 *
	 * @param string $string Any string
	 * @param string $substring Any substring
	 *
	 * @return bool
	 */
	public static function ends_with($string, $substring)
	{
		$length = strlen($substring);

		if ($length == 0)
		{
			return true;
		}

		return (substr($string, -$length) === $substring);
	}

	/**
	 * @en Find position of first occurrence of a string
	 * @ru Получение позиции указанной подстроки в строке
	 *
	 * $string_ASCII = 'ASCII string example';   # string(20) "ASCII string example"
	 * $string_UTF8  = 'UTF-8 string πράδειγμα'; # string(31) "UTF-8 string πράδειγμα"
	 *
	 * $result = string::find($string_ASCII, 'example');  # int(13)
	 * $result = string::find($string_UTF8, 'πράδειγμα'); # int(13)
	 *
	 * @param string $string Any string
	 * @param string $substring Any substring
	 * @param int $offset
	 *
	 * @return int
	 */
	public static function find($string, $substring, $offset = null)
	{
		if (string::is_utf8($string))
		{
			return mb_strpos($string, $substring, $offset, 'UTF-8');
		}

		return strpos($string, $substring, $offset);
	}


	/**
	 * @en Erase chars in the string after the specific position
	 * @ru Удаляет символы в строке после определённой позиции
	 *
	 * @param string $string Any string
	 * @param int $offset
	 * @param int $length
	 *
	 * @return string
	 */
	public static function erase($string, $offset, $length = null)
	{
		if ($length === null)
		{
			# string: `hello`
			# offset: 2
			# length: null
			# result: `he`

			return substr($string, 0, $offset);
		}

		if ($offset == 0)
		{
			# string: `hello`
			# offset: 0
			# length: 2
			# result: `llo`

			return string::read($string, string::length($string) - $length, $length);
		}


		# string: `hello`
		# offset: 2
		# length: 2
		# result: `heo`

		return string::read($string, $offset) . substr($string, $offset + $length);
	}

	/**
	 * @en Insert string at specified position
	 * @ru Вставка подстроки в определённую позицию в строке
	 *
	 * $string = string::insert('AAAA BBBB CCCC', 'DDDD', 5); # string(18) "AAAA DDDDBBBB CCCC"
	 *
	 * @param string $string Any string
	 * @param string $substring Any substring
	 * @param int $offset Substring offset for insert
	 *
	 * @return string
	 */
	public static function insert($string, $substring, $offset)
	{
		if ($offset == 0)
		{
			return $string . $substring;
		}

		return substr($string, 0, $offset) . $substring . substr($string, $offset);
	}

	/**
	 * @en Generating all permutations of a given string
	 * @ru Строковая комбинаторика. Получение всех возможны вариантов перестановок элементов строки
	 *
	 *
	 * $result = string::permutation('AAA BBB CCC DDD'); # Array
	 *                                                   # (
	 *                                                   #     [0] => AAA BBB CCC DDD
	 *                                                   #     [1] => AAA BBB DDD CCC
	 *                                                   #     [2] => AAA CCC DDD BBB
	 *                                                   #     [3] => AAA CCC BBB DDD
	 *                                                   #     [4] => AAA DDD BBB CCC
	 *                                                   #     [5] => AAA DDD CCC BBB
	 *                                                   #     [6] => BBB CCC DDD AAA
	 *                                                   #     [7] => BBB CCC AAA DDD
	 *                                                   #     [8] => BBB DDD AAA CCC
	 *                                                   #     [9] => BBB DDD CCC AAA
	 *                                                   #     [10] => BBB AAA CCC DDD
	 *                                                   #     [11] => BBB AAA DDD CCC
	 *                                                   #     [12] => CCC DDD AAA BBB
	 *                                                   #     [13] => CCC DDD BBB AAA
	 *                                                   #     [14] => CCC AAA BBB DDD
	 *                                                   #     [15] => CCC AAA DDD BBB
	 *                                                   #     [16] => CCC BBB DDD AAA
	 *                                                   #     [17] => CCC BBB AAA DDD
	 *                                                   #     [18] => DDD AAA BBB CCC
	 *                                                   #     [19] => DDD AAA CCC BBB
	 *                                                   #     [20] => DDD BBB CCC AAA
	 *                                                   #     [21] => DDD BBB AAA CCC
	 *                                                   #     [22] => DDD CCC AAA BBB
	 *                                                   #     [23] => DDD CCC BBB AAA
	 *                                                   # )
	 *
	 *
	 * @param string $string Any string
	 * @param string $delimiter
	 *
	 * @return array
	 */
	public static function permutation($string, $delimiter = ' ')
	{
		$array = items::permutation(explode($delimiter, $string));


		$result = null;

		foreach ($array as $item)
		{
			$result[] = implode(' ', $item);
		}

		return $result;
	}

	/**
	 * @en Returns the first line from the string
	 * @ru Возвращает первую строку из текста
	 *
	 * $string = "Hello\nHi\nWow!\n12345";
	 *
	 * $line = string::first($string); # string(5) "Hello"
	 *
	 * @param string $string Any string
	 * @param string $delimiter String delimiter
	 *
	 * @return string
	 */
	public static function first($string, $delimiter = PHP_EOL)
	{
		return string::line($string, 1, $delimiter);
	}

	/**
	 * @en Returns the last line from the string
	 * @ru Возвращает последнюю строку из текста
	 *
	 * $string = "Hello\nHi\nWow!\n12345";
	 *
	 * $line = string::last($string); # string(5) "12345"
	 *
	 * @param string $string Any string
	 * @param string $delimiter String delimiter
	 *
	 * @return string
	 */
	public static function last($string, $delimiter = PHP_EOL)
	{
		$count = string::count_lines($string);

		return string::line($string, $count + 1, $delimiter);
	}

	/**
	 * @en Return specific character from the string
	 * @ru Возвращает указанный символ из строки
	 *
	 * $string_ASCII = 'ASCII string example';   # string(20) "ASCII string example"
	 * $string_UTF8  = 'UTF-8 string πράδειγμα'; # string(31) "UTF-8 string πράδειγμα"
	 *
	 * $char = string::char($string_ASCII, 14); # string(1) "e"
	 * $char = string::char($string_ASCII, 15); # string(1) "x"
	 * $char = string::char($string_ASCII, 16); # string(1) "a"
	 *
	 * $char = string::char($string_UTF8, 14); # string(2) "π"
	 * $char = string::char($string_UTF8, 15); # string(2) "ρ"
	 * $char = string::char($string_UTF8, 16); # string(2) "ά"
	 *
	 * @param string $string Any string
	 * @param int $number Character number in the range from 1 to n (string length)
	 *
	 * @return string
	 */
	public static function char($string, $number)
	{
		return string::read($string, 1, $number - 1);
	}

	/**
	 * @en Convert a string to an array of chars
	 * @ru Преобразует строку в массив символов
	 *
	 * $string_ASCII = 'ASCII string example';   # string(20) "ASCII string example"
	 * $string_UTF8  = 'UTF-8 string πράδειγμα'; # string(31) "UTF-8 string πράδειγμα"
	 *
	 * $chars = string::chars($string_ASCII); # Array
	 *                                        # (
	 *                                        #     [0] => A
	 *                                        #     [1] => S
	 *                                        #     [2] => C
	 *                                        #     [3] => I
	 *                                        #     [4] => I
	 *                                        #     [5] =>
	 *                                        #     [6] => s
	 *                                        #     [7] => t
	 *                                        #     [8] => r
	 *                                        #     [9] => i
	 *                                        #     [10] => n
	 *                                        #     [11] => g
	 *                                        #     [12] =>
	 *                                        #     [13] => e
	 *                                        #     [14] => x
	 *                                        #     [15] => a
	 *                                        #     [16] => m
	 *                                        #     [17] => p
	 *                                        #     [18] => l
	 *                                        #     [19] => e
	 *                                        # )
	 *
	 * $chars = string::chars($string_UTF8);  # Array
	 *                                        # (
	 *                                        #     [0] => U
	 *                                        #     [1] => T
	 *                                        #     [2] => F
	 *                                        #     [3] => -
	 *                                        #     [4] => 8
	 *                                        #     [5] =>
	 *                                        #     [6] => s
	 *                                        #     [7] => t
	 *                                        #     [8] => r
	 *                                        #     [9] => i
	 *                                        #     [10] => n
	 *                                        #     [11] => g
	 *                                        #     [12] =>
	 *                                        #     [13] => π
	 *                                        #     [14] => ρ
	 *                                        #     [15] => ά
	 *                                        #     [16] => δ
	 *                                        #     [17] => ε
	 *                                        #     [18] => ι
	 *                                        #     [19] => γ
	 *                                        #     [20] => μ
	 *                                        #     [21] => α
	 *                                        # )
	 *
	 * @param string $string Any string
	 *
	 * @return array
	 */
	public static function chars($string)
	{
		if (string::is_utf8($string))
		{
			return preg_split('/(?<!^)(?!$)/u', $string);
		}

		return str_split($string, 1);
	}

	/**
	 * @en Returns the specified line from the string
	 * @ru Возвращает строку по указанному номеру в тексте
	 *
	 * $string = "Hello\nHi\nWow!\n12345";
	 *
	 * $line = string::line($string, 3); # string(4) "Wow!"
	 *
	 * @param string $string Any string
	 * @param int $number Line number (in the range of 1 to n)
	 * @param string $delimiter Line delimiter
	 *
	 * @return string
	 */
	public static function line($string, $number, $delimiter = PHP_EOL)
	{
		$lines = explode($delimiter, $string);

		if (count($lines) < $number)
		{
			return null;
		}

		return $lines[$number - 1];
	}

	/**
	 * @en Return specific lines from the string (or all lines if range is not provided)
	 * @ru Возвращает определённые строки из строки (или все строки в виде массива, если диапазон не был указан при вызове)
	 *
	 * $string = "First line\nSecond line\nThird line\netc";
	 *
	 * $lines = string::lines($string); # Array
	 *                                  # (
	 *                                  #     [0] => First line
	 *                                  #     [1] => Second line
	 *                                  #     [2] => Third line
	 *                                  #     [3] => etc
	 *                                  # )
	 *
	 * $lines = string::lines($string, 2); # Array
	 *                                     # (
	 *                                     #     [0] => Second line
	 *                                     #     [1] => Third line
	 *                                     #     [2] => etc
	 *                                     # )
	 *
	 * $lines = string::lines($string, 2, 3); # Array
	 *                                        # (
	 *                                        #     [0] => Second line
	 *                                        #     [1] => Third line
	 *                                        # )
	 *
	 *
	 * @param string $string Any string
	 * @param int $from
	 * @param int $to
	 * @param string $delimiter Line delimiter
	 *
	 * @return array
	 */
	public static function lines($string, $from = null, $to = null, $delimiter = PHP_EOL)
	{
		if ($from === null)
		{
			return explode($delimiter, $string);
		}

		if ($to === null)
		{
			$to = string::count($string, $delimiter) + 1;
		}

		if ($from < 1 or $from > $to)
		{
			return null;
		}


		$lines = explode($delimiter, $string);

		if (count($lines) < $to)
		{
			return null;
		}


		$result = null;

		for ($i = $from - 1; $i <= $to - 1; $i++)
		{
			$result[] = $lines[$i];
		}

		return $result;
	}

	/**
	 * @en Return specified word from the string
	 * @ru Возвращает слово из строки по его номеру в ней
	 *
	 * $string_ASCII = 'ASCII string example';   # string(20) "ASCII string example"
	 * $string_UTF8  = 'UTF-8 string πράδειγμα'; # string(31) "UTF-8 string πράδειγμα"
	 *
	 * $result = string::word($string_ASCII, 1); # string(5) "ASCII"
	 * $result = string::word($string_ASCII, 2); # string(6) "string"
	 * $result = string::word($string_ASCII, 3); # string(7) "example"
	 *
	 *
	 * # if you want to use this method with UTF-8 strings - you must specify language alphabet for the correct results:
	 *
	 * $alphabet = '1234567890-ΑΒΓΔΕΖΗΘΙΚΛΜΝΞΟΠΡΣΤΥΦΧΨΩαάβγδεζηθικλμνξοπρστυφχψω';
	 *
	 *
	 * $result = string::word($string_UTF8, 1, $alphabet); # string(5) "UTF-8"
	 * $result = string::word($string_UTF8, 2, $alphabet); # string(6) "string"
	 * $result = string::word($string_UTF8, 3, $alphabet); # string(18) "πράδειγμα"
	 *
	 * @param string $string
	 * @param int $number
	 * @param string $charlist
	 *
	 * @return string
	 */
	public static function word($string, $number, $charlist = null)
	{
		return str_word_count($string, 1, $charlist)[$number - 1];
	}

	/**
	 * @en Return all words from the string
	 * @ru Возвращает все слова, которые были найдены в строке
	 *
	 * $string_ASCII = 'ASCII string example';   # string(20) "ASCII string example"
	 * $string_UTF8  = 'UTF-8 string πράδειγμα'; # string(31) "UTF-8 string πράδειγμα"
	 *
	 *
	 * $result = string::words($string_ASCII);  debug($result, true); # Array
	 *                                                                # (
	 *                                                                #     [0] => ASCII
	 *                                                                #     [1] => string
	 *                                                                #     [2] => example
	 *                                                                # )
	 *
	 *
	 * # if you want to use this method with UTF-8 strings - you must specify language alphabet for the correct results:
	 *
	 * $alphabet = '1234567890-ΑΒΓΔΕΖΗΘΙΚΛΜΝΞΟΠΡΣΤΥΦΧΨΩαάβγδεζηθικλμνξοπρστυφχψω';
	 *
	 *
	 * $result = string::words($string_UTF8, $alphabet); # Array
	 *                                                   # (
	 *                                                   #     [0] => UTF-8
	 *                                                   #     [1] => string
	 *                                                   #     [2] => πράδειγμα
	 *                                                   # )
	 *
	 * @param string $string
	 * @param string $charlist
	 *
	 * @return array
	 */
	public static function words($string, $charlist = null)
	{
		return str_word_count($string, 1, $charlist);
	}

	/**
	 * @en Detect charset of string
	 * @ru Определяет кодировку строки
	 *
	 * $is_utf8 = string::is_utf8('ABCDEFАБВГДЕ'); # bool(true)
	 *
	 * @param $string
	 * @return bool
	 */
	public static function is_utf8($string)
	{
		########################################################################################
		# 1. Any UTF8 string is a valid 8-bit encoding string (even if it produces gibberish); #
		# 2. On the other hand, most 8-bit encoded strings with extended (128+) characters are #
		#    not valid UTF8, but, as any other random byte sequence, they might happen to be;  #
        # 3. Of course, any ASCII text is valid UTF8;                                          #
		# 4. Native mb_detect_encoding() is slow.                                              #
		########################################################################################

		if (preg_match('//u', $string))
		{
			return true; # it's UTF-8
		}

		return false; # it's something else
	}

	/**
	 * @en Check if a string contains BOM signature
	 * @ru Проверяет, встречается ли в строке сигнатура BOM
	 *
	 * @param string $string Any string
	 *
	 * @return bool
	 */
	public static function is_bom($string)
	{
		if (substr($string, 0, 3) == pack('CCC', 0xef, 0xbb, 0xbf))
		{
			return true;
		}

		return false;
	}

	/**
	 * @en Check if a string is an email address
	 * @ru Проверяет, является ли строка почтовым адресом
	 *
	 * @param string $string Any string
	 *
	 * @return bool
	 */
	public static function is_email($string)
	{
		if (filter_var($string, FILTER_VALIDATE_EMAIL))
		{
			return true;
		}

		return false;
	}

	/**
	 * @en Check if a string is an IP address
	 * @ru Проверяет, является ли строка IP адресом
	 *
	 * @param string $string Any string
	 *
	 * @return bool
	 */
	public static function is_ip($string)
	{
		if (filter_var($string, FILTER_VALIDATE_IP))
		{
			return true;
		}

		return false;
	}

	/**
	 * @en Check if a string is an URL address
	 * @ru Проверяет, является ли строка URL адресом
	 *
	 * @param string $string Any string
	 *
	 * @return bool
	 */
	public static function is_url($string)
	{
		if (filter_var($string, FILTER_VALIDATE_URL))
		{
			return true;
		}

		return false;
	}

	/**
	 * @en Checks if all of the characters in the provided string are printable
	 * @ru Проверяет, содержит ли переданная строка все символы, являющиеся отображаемыми
	 *
	 * string::is_printable("ABCDE");          # bool(true)
	 * string::is_printable("12345");          # bool(true)
	 * string::is_printable("Hello, Fred!");   # bool(true)
	 * string::is_printable("Newline\nFred!"); # bool(false)
	 *
	 * @param $char
	 *
	 * @return bool
	 */
	public static function is_printable($char)
	{
		return ctype_print($char);
	}

	/**
	 * @en Unpack data from binary string
	 * @ru Распаковка данных из бинарной строки
	 *
	 * @param string $format
	 * @param string $data
	 *
	 * @return mixed
	 */
	public static function unpack($format, $data)
	{
		$array = unpack($format, $data); # use origin unpack function

		return reset($array); # get the first item from the array
	}

	/**
	 * @en Convert character encoding to UTF-8
	 * @ru Преобразует строку в UTF-8 кодировку
	 *
	 * @param string $string
	 *
	 * @return string
	 */
	public static function to_utf8($string)
	{
		return mb_convert_encoding($string, 'utf-8', 'auto');
	}

	/**
	 * @en Make a string uppercase
	 * @ru Переводит строку в верхний регистр
	 *
	 * $string_ASCII = 'ASCII string example';   # string(20) "ASCII string example"
	 * $string_UTF8  = 'UTF-8 string πράδειγμα'; # string(31) "UTF-8 string πράδειγμα"
	 *
	 * $result = string::to_uppercase($string_ASCII); # string(20) "ASCII STRING EXAMPLE"
	 * $result = string::to_uppercase($string_UTF8);  # string(31) "UTF-8 STRING ΠΡΆΔΕΙΓΜΑ"
	 *
	 * @param string $string
	 *
	 * @return string
	 */
	public static function to_uppercase($string)
	{
		if (string::is_utf8($string))
		{
			return mb_strtoupper($string, 'UTF-8');
		}

		return strtoupper($string);
	}

	/**
	 * @en Make a string lowercase
	 * @ru Переводит строку в нижний регистр
	 *
	 * $string_ASCII = 'ASCII STRING EXAMPLE';   # string(20) "ASCII STRING EXAMPLE"
	 * $string_UTF8  = 'UTF-8 STRING ΠΡΆΔΕΙΓΜΑ'; # string(31) "UTF-8 STRING ΠΡΆΔΕΙΓΜΑ"
	 *
	 * $result = string::to_lowercase($string_ASCII); # string(20) "ascii string example"
	 * $result = string::to_lowercase($string_UTF8);  # string(31) "utf-8 string πράδειγμα"
	 *
	 * @param string $string Any string
	 *
	 * @return string
	 */
	public static function to_lowercase($string)
	{
		if (string::is_utf8($string))
		{
			return mb_strtolower($string, 'UTF-8');
		}

		return strtolower($string);
	}

	/***
	 * @en Remove duplicates from the string
	 * @ru Удаляет дубликаты из строки
	 *
	 * $string_ASCII = 'ASCII ASCII string example string';       # string(33) "ASCII ASCII string example string"
	 * $string_UTF8  = 'UTF-8 string πράδειγμα string πράδειγμα'; # string(57) "UTF-8 string πράδειγμα string πράδειγμα"
	 *
	 * $result = string::remove_duplicates($string_ASCII); # string(20) "ASCII string example"
	 * $result = string::remove_duplicates($string_UTF8);  # string(31) "UTF-8 string πράδειγμα"
	 *
	 * @param string $string Any string
	 * @param string $delimiter String delimiter
	 *
	 * @return string
	 */
	public static function remove_duplicates($string, $delimiter = ' ')
	{
		return implode($delimiter, array_unique(explode($delimiter, $string)));
	}

	/**
	 * @en Remove numbers from the string
	 * @ru Убирает числа из строки
	 *
	 * @param string $string Any string
	 *
	 * @return string
	 */
	public static function remove_numbers($string)
	{
		return preg_replace('/[0-9]+/', '', $string);
	}

	/**
	 * @en Remove BOM from the string
	 * @ru Удаляет сигнатуру BOM из строки
	 *
	 * @param string $string Any string
	 *
	 * @return string
	 */
	public static function remove_bom($string)
	{
		if (substr($string, 0, 3) == pack('CCC', 0xef, 0xbb, 0xbf))
		{
			return substr($string, 3);
		}

		return $string;
	}
}
