<?

namespace rude;

class specialties
{
	public static function get($id = null)
	{
		$database = new database();

		$q = '
			SELECT
				' . RUDE_DATABASE_TABLE_SPECIALTIES    . '.*,
				' . RUDE_DATABASE_TABLE_FACULTIES      . '.' . RUDE_DATABASE_FIELD_NAME      . ' AS faculty_name,
				' . RUDE_DATABASE_TABLE_FACULTIES      . '.' . RUDE_DATABASE_FIELD_SHORTNAME . ' AS faculty_shortname,
				' . RUDE_DATABASE_TABLE_QUALIFICATIONS . '.' . RUDE_DATABASE_FIELD_NAME      . ' AS qualification_name
			FROM
				' . RUDE_DATABASE_TABLE_SPECIALTIES    . '
			LEFT JOIN
				' . RUDE_DATABASE_TABLE_FACULTIES      . ' ON ' . RUDE_DATABASE_TABLE_SPECIALTIES . '.' . RUDE_DATABASE_FIELD_FACULTY_ID . ' = ' . RUDE_DATABASE_TABLE_FACULTIES . '.' . RUDE_DATABASE_FIELD_ID . '
			LEFT JOIN
				' . RUDE_DATABASE_TABLE_QUALIFICATIONS . ' ON ' . RUDE_DATABASE_TABLE_SPECIALTIES . '.' . RUDE_DATABASE_FIELD_QUALIFICATION_ID . ' = ' . RUDE_DATABASE_TABLE_QUALIFICATIONS . '.' . RUDE_DATABASE_FIELD_ID . '
		';


		if ($id !== null)
		{
			$q .= PHP_EOL . 'WHERE ' . RUDE_DATABASE_TABLE_SPECIALTIES . '.' . RUDE_DATABASE_FIELD_ID . ' = ' . (int) $id;
		}


		$q .= '
			GROUP BY
				' . RUDE_DATABASE_TABLE_SPECIALTIES . '.' . RUDE_DATABASE_FIELD_ID . '
		';

		$database->query($q);


		if ($id !== null)
		{
			return $database->get_object();
		}

		return $database->get_object_list();
	}

	public static function remove($id)
	{
		if (static::is_exists($id))
		{
			$q = new dquery(RUDE_DATABASE_TABLE_SPECIALTIES);
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
}