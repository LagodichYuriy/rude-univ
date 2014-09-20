<?

namespace rude;

class users
{
	public static function add($name, $password, $role_id = RUDE_ROLE_USER)
	{
		list($hash, $salt) = crypt::password($password);

		$q = new cquery(RUDE_DATABASE_TABLE_USERS);
		$q->add(RUDE_DATABASE_FIELD_NAME,    $name);
		$q->add(RUDE_DATABASE_FIELD_HASH,    $hash);
		$q->add(RUDE_DATABASE_FIELD_SALT,    $salt);
		$q->add(RUDE_DATABASE_FIELD_ROLE_ID, $role_id);
		$q->query();

		return $q->get_id();
	}

	public static function get($id = null)
	{
		$database = new database();

		$q = '
			SELECT
				' . RUDE_DATABASE_TABLE_USERS       . '.*,
				' . RUDE_DATABASE_TABLE_USERS_ROLES . '.' . RUDE_DATABASE_FIELD_NAME . ' AS role
			FROM
				' . RUDE_DATABASE_TABLE_USERS       . '
			LEFT JOIN
				' . RUDE_DATABASE_TABLE_USERS_ROLES . ' ON ' . RUDE_DATABASE_TABLE_USERS . '.' . RUDE_DATABASE_FIELD_ROLE_ID . ' = ' . RUDE_DATABASE_TABLE_USERS_ROLES . '.' . RUDE_DATABASE_FIELD_ID . '
		';

		if ($id !== null)
		{
			$q .= PHP_EOL . 'WHERE ' . RUDE_DATABASE_TABLE_USERS   . '.' . RUDE_DATABASE_FIELD_ID . ' = ' . (int) $id;
		}

		$q .= '
			GROUP BY
				' . RUDE_DATABASE_TABLE_USERS . '.' . RUDE_DATABASE_FIELD_ID . '
		';


		$database->query($q);


		if ($id !== null)
		{
			return $database->get_object();
		}

		return $database->get_object_list();
	}

	public static function get_by_name($name)
	{
		$q = new query(RUDE_DATABASE_TABLE_USERS);
		$q->where(RUDE_DATABASE_FIELD_NAME, $name);
		$q->query();

		return $q->get_object();
	}

	public static function is_exists($id)
	{
		$q = new query(RUDE_DATABASE_TABLE_USERS);
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
			$q = new dquery(RUDE_DATABASE_TABLE_USERS);
			$q->where(RUDE_DATABASE_FIELD_ID, (int) $id);
			$q->query();

			return true;
		}

		return false;
	}
}