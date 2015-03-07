<?

namespace rude;

class education_items_preview
{
	public static function get($id = null)
	{
		$q = new query(RUDE_DATABASE_TABLE_EDUCATION_ITEMS_PREVIEW);

		if ($id !== null)
		{
			$q->where(RUDE_DATABASE_FIELD_ID, (int) $id);
			$q->query();

			return $q->get_object();
		}

		$q->query();

		return $q->get_object_list();
	}

	public static function get_by_order($education_id)
	{
		$q = new query(RUDE_DATABASE_TABLE_EDUCATION_ITEMS_PREVIEW);


		$q->where('education_id', (int) $education_id);

		$q->order_by('order_num','ASC');
		$q->query();

		return $q->get_object_list();
	}


	public static function remove($id)
	{
		if (static::is_exists($id))
		{
			$q = new dquery(RUDE_DATABASE_TABLE_EDUCATION_ITEMS_PREVIEW);
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

	public static function add($education_id,$name,$order)
	{
		$q = new cquery(RUDE_DATABASE_TABLE_EDUCATION_ITEMS_PREVIEW);
		$q->add(RUDE_DATABASE_FIELD_NAME,$name);
		$q->add('order_num',$order);
		$q->add('education_id',$education_id);
		$q->query();

		return true;
	}

	public static function edit($id,$name,$shortname)
	{
//		$q = new uquery(RUDE_DATABASE_TABLE_EDUCATION_ITEMS_PREVIEW);
//		$q->update(RUDE_DATABASE_FIELD_NAME,$name);
//		$q->update(RUDE_DATABASE_FIELD_SHORTNAME,$shortname);
//		$q->where(RUDE_DATABASE_FIELD_ID,$id);
//		$q->query();

		return true;
	}
}