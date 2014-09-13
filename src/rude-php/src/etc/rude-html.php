<?

namespace rude;

class html
{
	public static function escape($string)
	{
		return htmlspecialchars($string);
	}

	public static function unescape($string)
	{
		return htmlspecialchars_decode($string);
	}

	public static function js($path)
	{
		return '<script src="' . $path . '" type="text/javascript"></script>';
	}

	public static function css($path)
	{
		return '<link href="' . $path . '" rel="stylesheet" type="text/css">';
	}
}