<?

namespace rude;

class faculties
{
	public static function get($id = null)
	{
		$q = new query(RUDE_DATABASE_TABLE_FACULTIES);

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
			$q = new dquery(RUDE_DATABASE_TABLE_FACULTIES);
			$q->where(RUDE_DATABASE_FIELD_ID, (int) $id);
			$q->query();

			return true;
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

	public static function add($name,$shortname)
	{
		$q = new cquery(RUDE_DATABASE_TABLE_FACULTIES);
		$q->add(RUDE_DATABASE_FIELD_NAME,$name);
		$q->add(RUDE_DATABASE_FIELD_SHORTNAME,$shortname);
		$q->query();

		return true;
	}
}