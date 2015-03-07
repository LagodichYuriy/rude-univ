<?

namespace rude;

class reports
{
	public static function get($id = null)
	{
		$database = new database();

		$q = '
			SELECT
				' . RUDE_DATABASE_TABLE_REPORTS         . '.*,

				' . RUDE_DATABASE_TABLE_FACULTIES       . '.' . RUDE_DATABASE_FIELD_ID        . ' AS faculty_id,
				' . RUDE_DATABASE_TABLE_FACULTIES       . '.' . RUDE_DATABASE_FIELD_NAME      . ' AS faculty_name,
				' . RUDE_DATABASE_TABLE_FACULTIES       . '.' . RUDE_DATABASE_FIELD_SHORTNAME . ' AS faculty_shortname,

				' . RUDE_DATABASE_TABLE_SPECIALTIES     . '.' . RUDE_DATABASE_FIELD_ID        . ' AS specialty_id,
				' . RUDE_DATABASE_TABLE_SPECIALTIES     . '.' . RUDE_DATABASE_FIELD_NAME      . ' AS specialty_name,

				' . RUDE_DATABASE_TABLE_SPECIALIZATIONS . '.' . RUDE_DATABASE_FIELD_ID        . ' AS specialization_id,
				' . RUDE_DATABASE_TABLE_SPECIALIZATIONS . '.' . RUDE_DATABASE_FIELD_NAME      . ' AS specialization_name,

				' . RUDE_DATABASE_TABLE_TRAINING_FORM   . '.' . RUDE_DATABASE_FIELD_ID        . ' AS training_form_id,
				' . RUDE_DATABASE_TABLE_TRAINING_FORM   . '.' . RUDE_DATABASE_FIELD_NAME      . ' AS training_form_name,

				' . RUDE_DATABASE_TABLE_QUALIFICATIONS  . '.' . RUDE_DATABASE_FIELD_ID        . ' AS qualification_id,
				' . RUDE_DATABASE_TABLE_QUALIFICATIONS  . '.' . RUDE_DATABASE_FIELD_NAME      . ' AS qualification_name
			FROM
				' . RUDE_DATABASE_TABLE_REPORTS . '
			LEFT JOIN
				' . RUDE_DATABASE_TABLE_SPECIALTIES     . ' ON ' . RUDE_DATABASE_TABLE_REPORTS . '.' . RUDE_DATABASE_FIELD_SPECIALTY_ID      . ' = ' . RUDE_DATABASE_TABLE_SPECIALTIES     . '.' . RUDE_DATABASE_FIELD_ID . '
			LEFT JOIN
				' . RUDE_DATABASE_TABLE_FACULTIES       . ' ON ' . RUDE_DATABASE_TABLE_SPECIALTIES . '.' . RUDE_DATABASE_FIELD_FACULTY_ID    . ' = ' . RUDE_DATABASE_TABLE_FACULTIES       . '.' . RUDE_DATABASE_FIELD_ID . '
			LEFT JOIN
				' . RUDE_DATABASE_TABLE_SPECIALIZATIONS . ' ON ' . RUDE_DATABASE_TABLE_REPORTS . '.' . RUDE_DATABASE_FIELD_SPECIALIZATION_ID . ' = ' . RUDE_DATABASE_TABLE_SPECIALIZATIONS . '.' . RUDE_DATABASE_FIELD_ID . '
			LEFT JOIN
				' . RUDE_DATABASE_TABLE_TRAINING_FORM   . ' ON ' . RUDE_DATABASE_TABLE_REPORTS . '.' . RUDE_DATABASE_FIELD_TRAINING_FORM_ID  . ' = ' . RUDE_DATABASE_TABLE_TRAINING_FORM   . '.' . RUDE_DATABASE_FIELD_ID . '
			LEFT JOIN
				' . RUDE_DATABASE_TABLE_QUALIFICATIONS  . ' ON ' . RUDE_DATABASE_TABLE_REPORTS . '.' . RUDE_DATABASE_FIELD_QUALIFICATION_ID  . ' = ' . RUDE_DATABASE_TABLE_QUALIFICATIONS  . '.' . RUDE_DATABASE_FIELD_ID . '
			WHERE 1 = 1

		';


		if ($id !== null)
		{
			$q .= PHP_EOL . 'AND ' . RUDE_DATABASE_TABLE_REPORTS . '.' . RUDE_DATABASE_FIELD_ID . ' = ' . (int) $id;
		}

		$q .= '
			GROUP BY
				' . RUDE_DATABASE_TABLE_REPORTS . '.' . RUDE_DATABASE_FIELD_ID;


		$database->query($q);


		if ($id !== null)
		{
			return $database->get_object();
		}

		return $database->get_object_list();
	}

	public static function is_exists($id)
	{
		$q = new query(RUDE_DATABASE_TABLE_REPORTS);
		$q->where(RUDE_DATABASE_FIELD_ID, (int) $id);
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
			$q = new dquery(RUDE_DATABASE_TABLE_REPORTS);
			$q->where(RUDE_DATABASE_FIELD_ID, (int) $id);
			$q->query();

			return $q->affected();
		}

		return false;
	}

	public static function add($year                = null,
							   $duration            = null,
							   $rector              = null,
							   $registration_number = null,
							   $training_form_id    = null,
							   $qualification_id    = null,
							   $specialty_id        = null,
							   $specialization_id   = null)
	{
		$q = new cquery(RUDE_DATABASE_TABLE_REPORTS);
		$q->add(RUDE_DATABASE_FIELD_YEAR,                (int) $year);
		$q->add(RUDE_DATABASE_FIELD_DURATION,            (int) $duration);
		$q->add(RUDE_DATABASE_FIELD_RECTOR,                    $rector);
		$q->add(RUDE_DATABASE_FIELD_REGISTRATION_NUMBER,       $registration_number);
		$q->add(RUDE_DATABASE_FIELD_TRAINING_FORM_ID,    (int) $training_form_id);
		$q->add(RUDE_DATABASE_FIELD_QUALIFICATION_ID,    (int) $qualification_id);
		$q->add(RUDE_DATABASE_FIELD_SPECIALTY_ID,        (int) $specialty_id);
		$q->add(RUDE_DATABASE_FIELD_SPECIALIZATION_ID,   (int) $specialization_id);

		$q->query();

		return $q->get_id();
	}

	public static function update($id,
	                              $year                = null,
	                              $duration            = null,
	                              $rector              = null,
	                              $registration_number = null,
	                              $training_form_id    = null,
	                              $qualification_id    = null,
	                              $specialty_id        = null,
	                              $specialization_id   = null)
	{
		$q = new uquery(RUDE_DATABASE_TABLE_REPORTS);

		if ($year                !== null) { $q->update(RUDE_DATABASE_FIELD_YEAR,                (int) $year);                }
		if ($duration            !== null) { $q->update(RUDE_DATABASE_FIELD_DURATION,            (int) $duration);            }
		if ($rector              !== null) { $q->update(RUDE_DATABASE_FIELD_RECTOR,                    $rector);              }
		if ($registration_number !== null) { $q->update(RUDE_DATABASE_FIELD_REGISTRATION_NUMBER,       $registration_number); }
		if ($training_form_id    !== null) { $q->update(RUDE_DATABASE_FIELD_TRAINING_FORM_ID,    (int) $training_form_id);    }
		if ($qualification_id    !== null) { $q->update(RUDE_DATABASE_FIELD_QUALIFICATION_ID,    (int) $qualification_id);    }
		if ($specialty_id        !== null) { $q->update(RUDE_DATABASE_FIELD_SPECIALTY_ID,        (int) $specialty_id);        }
		if ($specialization_id   !== null) { $q->update(RUDE_DATABASE_FIELD_SPECIALIZATION_ID,   (int) $specialization_id);   }

		$q->where(RUDE_DATABASE_FIELD_ID, (int) $id);
		$q->query();


		return true;
	}
}