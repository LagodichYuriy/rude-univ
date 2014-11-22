<?

namespace rude;

class reports_categories_items
{
	public static function get($id = null)
	{
		$q = new query(RUDE_DATABASE_TABLE_REPORTS_CATEGORIES_ITEMS);

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
			$q = new dquery(RUDE_DATABASE_TABLE_REPORTS_CATEGORIES_ITEMS);
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

	public static function add($name, $discipline_id, $order = 0)
	{
		$q = new cquery(RUDE_DATABASE_TABLE_REPORTS_CATEGORIES_ITEMS);
		$q->add(RUDE_DATABASE_FIELD_NAME, $name);
		$q->add(RUDE_DATABASE_FIELD_DISCIPLINE_ID, (int) $discipline_id);
		$q->add(RUDE_DATABASE_FIELD_ORDER, (int) $order);
		$q->query();

		return true;
	}
}