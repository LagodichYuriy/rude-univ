<?

namespace rude;

class training_forms
{
	public static function get($id = null)
	{
		$q = new query(RUDE_DATABASE_TABLE_TRAINING_FORM);

		if ($id !== null)
		{
			$q->where(RUDE_DATABASE_FIELD_ID, (int) $id);
			$q->query();

			return $q->get_object();
		}

		$q->query();

		return $q->get_object_list();
	}

	public static function is_exists($name)
	{
		$q = new query(RUDE_DATABASE_TABLE_TRAINING_FORM);
		$q->where(RUDE_DATABASE_FIELD_NAME, $name);
		$q->query();

		if ($q->get_object())
		{
			return true;
		}

		return false;
	}

	public static function remove($id)
	{
		if (static::is_exists($id))
		{
			$q = new dquery(RUDE_DATABASE_TABLE_TRAINING_FORM);
			$q->where(RUDE_DATABASE_FIELD_ID, (int) $id);
			$q->query();

			return true;
		}

		return false;
	}
}