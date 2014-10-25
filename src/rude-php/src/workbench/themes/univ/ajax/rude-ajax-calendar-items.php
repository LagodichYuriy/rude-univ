<?

namespace rude;

class ajax_calendar_items
{
	public static function init()
	{
		if (!template_session::is_admin() and !template_session::is_editor())
		{
			if (get('ajax'))
			{
				exit(RUDE_AJAX_ACCESS_VIOLATION);
			}

			return false;
		}


		switch (get('task'))
		{
			case 'save': static::save(); exit;

			default:
				break;
		}

		return true;
	}

	public static function save()
	{
		$data = get('data');

		$report_id = get('report_id');

		if (!$data or !$report_id)
		{
			return false;
		}

		if (calendar_items::is_exists($report_id))
		{
			calendar_items::remove($report_id);
		}


		foreach ($data as $item)
		{
			calendar_items::add($report_id, get(0, $item), get(1, $item), get(2, $item));
		}

		debug($data);


		return true;
	}
}