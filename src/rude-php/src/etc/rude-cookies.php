<?

namespace rude;

class cookies
{
	public static function set($name, $value = 1, $expire = RUDE_TIME_MONTH)
	{
		return setcookie($name, $value, time() + $expire);
	}

	public static function delete($name)
	{
		return setcookie($name, "", time() - RUDE_TIME_YEAR);
	}

	public static function is_exists($name, $value = false)
	{
		if ($value === false)
		{
			return get($name, $_COOKIE) === null;
		}

		return cookies::is_equals($name, $value);
	}

	public static function is_equals($name, $value)
	{
		if (get($name, $_COOKIE) == $value)
		{
			return true;
		}

		return false;
	}


}