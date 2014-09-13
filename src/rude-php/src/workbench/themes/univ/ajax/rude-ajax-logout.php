<?

namespace rude;

class ajax_logout
{
	public static function init()
	{
		template_session::logout();
	}
}