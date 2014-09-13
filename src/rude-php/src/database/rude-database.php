<?

namespace rude;

/**
 * @category database
 */
class database
{
	/** @var \mysqli  */
	private $mysqli = null;

	/** @var \mysqli_result  */
	private $result = null;

	private $limit = null;    # `LIMIT %O%,%L%`

	private $order_by = null; # `ORDER BY %FIELD% %DIRECTION%`

	public function __construct($host = RUDE_DATABASE_HOST,
                                $user = RUDE_DATABASE_USER,
                                $pass = RUDE_DATABASE_PASS,
                                $name = RUDE_DATABASE_NAME)
	{
		$this->mysqli = new \mysqli($host, $user, $pass, $name);

		if ($this->mysqli->connect_errno)
		{
			debug($this->mysqli->connect_errno);
		}

		if (!$this->mysqli->set_charset("utf8"))
		{
			debug($this->mysqli->connect_errno);
		}
	}

	/**
	 * @en Execute SQL query. WARNING: do not forget to escape SQL queries via escape() method if you don't use query() classes
	 * @ru Выполнение построенного SQL запроса. ВАЖНО: не забывайте экранировать SQL запросы с помощью метода escape() если вы генерируете SQL запрос без помощи семейства классов query()
	 *
	 * $database = new database(); # do not forget to declare defines before calling this class:
	 *                             # > RUDE_DATABASE_USER
	 *                             # > RUDE_DATABASE_PASS
	 *                             # > RUDE_DATABASE_HOST
	 *                             # > RUDE_DATABASE_NAME
	 *
	 * $database->query('SELECT * FROM users WHERE 1 = 1');
	 *
	 * @param $string
	 *
	 * @return mixed
	 */
	public function query($string)
	{
		$string .= $this->order_by;
		$string .= $this->limit;


		$this->result = $this->mysqli->query($string);


		if ($this->result === false)
		{
			debug($string);
		}

		return $this->result;
	}

	public function escape($var)
	{
		return $this->mysqli->real_escape_string($var);
	}

	public function insert_id()
	{
		return $this->mysqli->insert_id;
	}

	public function columns($table)
	{
		$sql = 'SHOW COLUMNS FROM ' . $this->escape($table);

		$result = $this->query($sql);


		$table_columns = null;

		while ($column = $result->fetch_row())
		{
			if (!empty($column[0]))
			{
				$table_columns[] = $column[0]; # [0] - field
				                               # [1] - type
				                               # [2] - null
				                               # [3] - key
				                               # [4] - default
				                               # [5] - extra
			}
		}

		return $table_columns;
	}

	public function limit($limit, $offset = false)
	{
		if (is_int($limit))
		{
			if (is_int($offset))
			{
				$this->limit = '			LIMIT' . PHP_EOL . '				' . (int) $offset . ',' . (int) $limit . PHP_EOL;
				return;
			}

			$this->limit = '			LIMIT' . PHP_EOL . '				' . (int) $limit . PHP_EOL;
			return;
		}
	}

	public function order_by($field, $direction = 'ASC')
	{
		if (!$field)
		{
			return;
		}

		$this->order_by = '	ORDER BY' . PHP_EOL . '				' . $this->escape($field) . ' ' . $this->escape($direction) . PHP_EOL;
	}

	/**
	 * @en Get query result as an object list
	 * @ru Получить ответ из базы данных в виде массива объектов
	 *
	 * $database = new database(); # do not forget to declare defines before calling this class:
	 *                             # > RUDE_DATABASE_USER
	 *                             # > RUDE_DATABASE_PASS
	 *                             # > RUDE_DATABASE_HOST
	 *                             # > RUDE_DATABASE_NAME
	 *
	 * $database->query('SELECT * FROM users WHERE 1 = 1');
	 *
	 * $result = $database->get_object_list(); # Array
	 *                                         # (
	 *                                         #     [0] => stdClass Object
	 *                                         #     (
	 *                                         #         [id] => 1
	 *                                         #         [username] => root
	 *                                         #         [hash] => e7ee2c83e86af973196fde64e1ab7178
	 *                                         #         [salt] => Jb9JbfrQoBRs7p0mNu3i7NSsC9AhuaCz
	 *                                         #         [role_id] => 1
	 *                                         #     )
	 *                                         #
	 *                                         #     [1] => stdClass Object
	 *                                         #     (
	 *                                         #         [id] => 2
	 *                                         #         [username] => manager
	 *                                         #         [hash] => 0991b08461e5ce0ee0a038c104b5a6d3
	 *                                         #         [salt] => nLpUwvzSpD5yoqXtqjvhtqwhJUsMFh8P
	 *                                         #         [role_id] => 2
	 *                                         #     )
	 *                                         # )
	 *
	 * @return mixed
	 */
	public function get_object_list()
	{
		$object_list = array();

		while ($object = $this->result->fetch_object())
		{
			$object_list[] = $object;
		}

		return $object_list;
	}

	/**
	 * @en Get element from query result as an object
	 * @ru Получить первую запись из ответа базы данных в виде объекта
	 *
	 * $database = new database(); # do not forget to declare defines before calling this class:
	 *                             # > RUDE_DATABASE_USER
	 *                             # > RUDE_DATABASE_PASS
	 *                             # > RUDE_DATABASE_HOST
	 *                             # > RUDE_DATABASE_NAME
	 *
	 * $database->query('SELECT * FROM users WHERE 1 = 1');
	 *
	 * $result = $database->get_object(); # stdClass Object
	 *                                    # (
	 *                                    #     [id] => 2
	 *                                    #     [username] => manager
	 *                                    #     [hash] => 0991b08461e5ce0ee0a038c104b5a6d3
	 *                                    #     [salt] => nLpUwvzSpD5yoqXtqjvhtqwhJUsMFh8P
	 *                                    #     [role_id] => 2
	 *                                    # )
	 *
	 * @return mixed
	 */
	public function get_object()
	{
		if ($object = $this->result->fetch_object())
		{
			return $object;
		}

		return null;
	}
}