<?

namespace rude;

class calendar_items
{
	public static function get($report_id = null)
	{
		$q = new query(RUDE_DATABASE_TABLE_CALENDAR_ITEMS);

		if ($report_id !== null)
		{
			$q->where(RUDE_DATABASE_FIELD_REPORT_ID, (int) $report_id);
			$q->query();

			return $q->get_object_list();
		}

		$q->query();

		return $q->get_object_list();
	}

	public static function add($report_id, $year, $column, $value)
	{
		$q = new cquery(RUDE_DATABASE_TABLE_CALENDAR_ITEMS);
		$q->add(RUDE_DATABASE_FIELD_REPORT_ID, (int) $report_id);
		$q->add(RUDE_DATABASE_FIELD_YEAR, $year);
		$q->add(RUDE_DATABASE_FIELD_COLUMN, (int) $column);
		$q->add(RUDE_DATABASE_FIELD_VALUE, $value);
		$q->query();

		return $q->get_id();
	}

	public static function remove($report_id)
	{
		$q = new dquery(RUDE_DATABASE_TABLE_CALENDAR_ITEMS);
		$q->where(RUDE_DATABASE_FIELD_REPORT_ID, (int) $report_id);
		$q->query();
	}

	public static function is_exists($report_id)
	{
		if (static::get($report_id))
		{
			return true;
		}

		return false;
	}
}