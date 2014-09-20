<?

namespace rude;

class template_url
{
	public static function image($name)
	{
		return RUDE_URL_IMAGES . '/' . $name;
	}
}