<?

namespace rude;

class calendar_legend
{
	public static function get($id = null)
	{
		$q = new query(RUDE_DATABASE_TABLE_CALENDAR_LEGEND);

		if ($id !== null)
		{
			$q->where(RUDE_DATABASE_FIELD_ID, (int) $id);
			$q->query();

			return $q->get_object();
		}

		$q->query();

		return $q->get_object_list();
	}

	public static function remove($id)
	{
		if (static::is_exists($id))
		{
			$q = new dquery(RUDE_DATABASE_TABLE_CALENDAR_LEGEND);
			$q->where(RUDE_DATABASE_FIELD_ID, (int) $id);
			$q->query();

			return $q->affected();
		}

		return false;
	}

	public static function is_exists($id)
	{
		if (static::get($id))
		{
			return true;
		}

		return false;
	}

	public static function add($legend_letter,$description)
	{
		$q = new cquery(RUDE_DATABASE_TABLE_CALENDAR_LEGEND);
		$q->add(RUDE_DATABASE_FIELD_LEGEND_LETTER,$legend_letter);
		$q->add(RUDE_DATABASE_FIELD_LEGEND_DESCRIPTION,$description);
		$q->query();

		return true;
	}

	public static function edit($id,$legend_letter,$description)
	{
		$q = new uquery(RUDE_DATABASE_TABLE_CALENDAR_LEGEND);
		$q->update(RUDE_DATABASE_FIELD_LEGEND_LETTER,$legend_letter);
		$q->update(RUDE_DATABASE_FIELD_LEGEND_DESCRIPTION,$description);
		$q->where(RUDE_DATABASE_FIELD_ID,$id);
		$q->query();

		return true;
	}
}