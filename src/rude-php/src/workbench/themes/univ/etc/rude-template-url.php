<?

namespace rude;

class template_url
{
	public static function image($name)
	{
		return RUDE_URL_IMAGES . '/' . $name;
	}

	public static function ajax($page, $task, $id)
	{
		return '/?page=' . html::escape($page) . '&task=' . html::escape($task) . '&id=' . html::escape($id) . '&ajax=true';
	}
}