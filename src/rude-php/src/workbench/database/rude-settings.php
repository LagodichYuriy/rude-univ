<?

namespace rude;

class settings
{

	public static function get($user_id)
	{
		$q = new query(RUDE_DATABASE_TABLE_SETTINGS);
		$q->where(RUDE_DATABASE_FIELD_USER_ID, (int) $user_id);
		$q->query();
		return $q->get_object_list();
	}

	public static function get_rector_value($user_id)
	{
		$q = new query(RUDE_DATABASE_TABLE_SETTINGS);
		$q->where(RUDE_DATABASE_FIELD_USER_ID, (int) $user_id);
		$q->where(RUDE_DATABASE_FIELD_NAME, 'rector');
		$q->query();
		return $q->get_object();
	}

	public static function get_popup($user_id)
	{
		$q = new query(RUDE_DATABASE_TABLE_SETTINGS);
		$q->where(RUDE_DATABASE_FIELD_USER_ID, (int) $user_id);
		$q->where(RUDE_DATABASE_FIELD_NAME,'popup');
		$q->query();
		return $q->get_object();
	}

	public static function is_exists($id)
	{
		if (static::get($id))
		{
			return true;
		}

		return false;
	}

	public static function add($user_id)
	{
		$q = new cquery(RUDE_DATABASE_TABLE_SETTINGS);
		$q->add(RUDE_DATABASE_FIELD_USER_ID,$user_id);
		$q->add(RUDE_DATABASE_FIELD_NAME,'rector');
		$q->add(RUDE_DATABASE_FIELD_VALUE,'');
		$q->query();

		$q = new cquery(RUDE_DATABASE_TABLE_SETTINGS);
		$q->add(RUDE_DATABASE_FIELD_USER_ID,$user_id);
		$q->add(RUDE_DATABASE_FIELD_NAME,'popup');
		$q->add(RUDE_DATABASE_FIELD_VALUE,'false');
		$q->query();
		return true;
	}

	public static function save($popup_id,$popup,$rector_id,$rector)
	{
		$q = new uquery(RUDE_DATABASE_TABLE_SETTINGS);
		$q->update(RUDE_DATABASE_FIELD_VALUE,$popup);
		$q->where(RUDE_DATABASE_FIELD_ID,$popup_id);
		$q->query();

		$q = new uquery(RUDE_DATABASE_TABLE_SETTINGS);
		$q->update(RUDE_DATABASE_FIELD_VALUE,$rector);
		$q->where(RUDE_DATABASE_FIELD_ID,$rector_id);
		$q->query();

		return true;
	}
}