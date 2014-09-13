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
		$q = new query(RUDE_DATABASE_TABLE_USERS);

		if ($id !== null)
		{
			$q->where(RUDE_DATABASE_FIELD_ID, (int) $id);
			$q->query();

			return $q->get_object();
		}

		$q->query();

		return $q->get_object_list();
	}

	public static function get_by_name($name)
	{
		$q = new query(RUDE_DATABASE_TABLE_USERS);
		$q->where(RUDE_DATABASE_FIELD_NAME, $name);
		$q->query();

		return $q->get_object();
	}

	public static function is_exists($name)
	{
		$q = new query(RUDE_DATABASE_TABLE_USERS);
		$q->where(RUDE_DATABASE_FIELD_NAME, $name);
		$q->query();

		if ($q->get_object())
		{
			return true;
		}

		return false;
	}
}