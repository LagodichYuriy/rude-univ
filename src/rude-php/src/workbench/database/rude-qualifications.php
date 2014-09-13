<?

namespace rude;

class qualifications
{
	public static function get($id = null)
	{
		$q = new query(RUDE_DATABASE_TABLE_QUALIFICATIONS);

		if ($id !== null)
		{
			$q->where(RUDE_DATABASE_FIELD_ID, (int) $id);
			$q->query();

			return $q->get_object();
		}

		$q->query();

		return $q->get_object_list();
	}
}