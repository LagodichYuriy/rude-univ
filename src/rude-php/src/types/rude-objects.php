<?

namespace rude;

/**
 * @category types
 */
class objects
{
	/**
	 * @en Check if at least any object in the provided list contains property with specific field and specific value
	 * @ru Проверяет, содержит ли хотя бы один объект из списка поле с указанным значением
	 *
	 * @param array $object_list
	 * @param string $object_field
	 * @param mixed $object_value
	 *
	 * @return bool
	 */
	public static function contains($object_list, $object_field, $object_value)
	{
		if (!$object_list)
		{
			return false;
		}

		foreach ($object_list as $object)
		{
			if ($object->$object_field == $object_value)
			{
				return true;
			}
		}

		return false;
	}
}