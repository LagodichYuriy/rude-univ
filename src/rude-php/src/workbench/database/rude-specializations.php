<?

namespace rude;

class specializations
{
	public static function get($id = null)
	{
		$q = new query(RUDE_DATABASE_TABLE_SPECIALIZATIONS);

		if ($id !== null)
		{
			$q->where(RUDE_DATABASE_FIELD_ID, (int) $id);
			$q->query();

			return $q->get_object();
		}

		$q->order_by(RUDE_DATABASE_FIELD_NAME);
		$q->query();

		return $q->get_object_list();
	}

	public static function remove($id)
	{
		if (static::is_exists($id))
		{
			$q = new dquery(RUDE_DATABASE_TABLE_SPECIALIZATIONS);
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

	public static function add($name,$code)
	{
		$q = new cquery(RUDE_DATABASE_TABLE_SPECIALIZATIONS);
		$q->add(RUDE_DATABASE_FIELD_NAME, $name);
		$q->add('code',$code);
		$q->query();

		return true;
	}


	public static function edit($id,$name,$code)
	{
		$q = new uquery(RUDE_DATABASE_TABLE_SPECIALIZATIONS);
		$q->update(RUDE_DATABASE_FIELD_NAME,$name);
		$q->update('code',$code);
		$q->where(RUDE_DATABASE_FIELD_ID,$id);
		$q->query();

		return true;
	}
}