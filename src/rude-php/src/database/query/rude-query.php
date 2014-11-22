<?

namespace rude;

/**
 * @category database
 *
 * ######################################################################
 * # class query() - is a simple MySQL/MariaDB SQL query object builder #
 * ######################################################################
 *
 *
 * #########################################
 * # select all data from a `users` table: #
 * #########################################
 *
 * $q = new query('users');
 * $q->query();                    # SELECT *
 *                                 # FROM users
 *                                 # WHERE 1 = 1
 *                                 # ORDER BY username ASC
 *
 * $users = $q->get_object_list(); # Array
 *                                 # (
 *                                 #     [0] => stdClass Object
 *                                 #     (
 *                                 #         [id] => 1
 *                                 #         [username] => root
 *                                 #         [hash] => e7ee2c83e86af973196fde64e1ab7178
 *                                 #         [salt] => Jb9JbfrQoBRs7p0mNu3i7NSsC9AhuaCz
 *                                 #         [role_id] => 1
 *                                 #     )
 *                                 #
 *                                 #     [1] => stdClass Object
 *                                 #     (
 *                                 #         [id] => 2
 *                                 #         [username] => manager
 *                                 #         [hash] => 0991b08461e5ce0ee0a038c104b5a6d3
 *                                 #         [salt] => nLpUwvzSpD5yoqXtqjvhtqwhJUsMFh8P
 *                                 #         [role_id] => 2
 *                                 #     )
 *                                 # )
 *
 *
 *
 * ##############################
 * # get only specified fields: #
 * ##############################
 *
 * $q = new query('users');
 * $q->field('hash');
 * $q->field('salt');
 * $q->query();                     # SELECT hash, salt
 *                                  # FROM users
 *                                  # WHERE 1 = 1
 *
 * $result = $q->get_object_list(); # Array
 *                                  # (
 *                                  #     [0] => stdClass Object
 *                                  #     (
 *                                  #         [hash] => e7ee2c83e86af973196fde64e1ab7178
 *                                  #         [salt] => Jb9JbfrQoBRs7p0mNu3i7NSsC9AhuaCz
 *                                  #     )
 *                                  #
 *                                  #     [1] => stdClass Object
 *                                  #     (
 *                                  #         [hash] => 0991b08461e5ce0ee0a038c104b5a6d3
 *                                  #         [salt] => nLpUwvzSpD5yoqXtqjvhtqwhJUsMFh8P
 *                                  #     )
 *                                  # )
 *
 * #########################
 * # with WHERE statement: #
 * #########################
 *
 * $q = new query('users');
 * $q->where('id', 1);
 * $q->query();                    # SELECT *
 *                                 # FROM users
 *                                 # WHERE id = 1
 *
 * $users = $q->get_object_list(); # Array
 *                                 # (
 *                                 #     [0] => stdClass Object
 *                                 #     (
 *                                 #         [id] => 1
 *                                 #         [username] => root
 *                                 #         [hash] => e7ee2c83e86af973196fde64e1ab7178
 *                                 #         [salt] => Jb9JbfrQoBRs7p0mNu3i7NSsC9AhuaCz
 *                                 #         [role_id] => 1
 *                                 #     )
 *                                 # )
 *
 *
 * #####################################################################
 * # more examples can be found in the selected functions of the class #
 * #####################################################################
 */
class query
{
	/** @var database  */
	private $database = null;          # database class


	private $field_list = null;        # [optional] SELECT
	private $from_table = null;        # [required] FROM
	private $left_join_list = null;    # [optional] LEFT JOIN
	private $right_join_list = null;   # [optional] RIGHT JOIN
	private $where_list = null;        # [optional] WHERE
	private $group_by = null;          # [optional] GROUP BY
	private $order_by = null;          # [optional] ORDER BY
	private $order_direction = null;   # [optional] ASC/DESC
	private $offset = null;            # [optional] LIMIT
	private $limit = null;             # [optional] LIMIT


	private $left_join_tables = null;  # [autogen]
	private $right_join_tables = null; # [autogen]


	/** @var \mysqli_result */
	private $result = null;            # query result

	/**
	 * @en Class constructor. You must pass table name as argument here
	 * @ru Конструктор класса. Необходимо передать название таблицы для дальнейшей работы с ней
	 *
	 * $q = new query('users');
	 * $q->query();                    # SELECT *
	 *                                 # FROM users   <--- selected table
	 *                                 # WHERE 1 = 1
	 *
	 * @param $from_table
	 */
	public function __construct($from_table)
	{
		$this->database = new database();

		$this->from_table = $this->escape($from_table);
	}

	/**
	 * @en Show table columns
	 * @ru Отобразить колонки выбранной таблицы
	 *
	 * $q = new query('users');
	 *
	 * $columns = $q->columns(); # Array
	 *                           # (
	 *                           #     [0] => id
	 *                           #     [1] => username
	 *                           #     [2] => hash
	 *                           #     [3] => salt
	 *                           #     [4] => role_id
	 *                           # )
	 *
	 * @param bool $table
	 *
	 * @return array
	 */
	public function columns($table = null)
	{
		if ($table === null)
		{
			$table = $this->escape($this->from_table);
		}

		return $this->database->columns($table);
	}

	public function dummy()
	{
		$result = new \stdClass();


		$columns = $this->columns();

		foreach ($columns as $column)
		{
			$result->{$column} = null;
		}

		return $result;
	}

	/**
	 * @en Select specify columns from the database
	 * @ru Выбрать колонки для последующего запроса из базы данных
	 *
	 * $q = new query('users');
	 * $q->field('hash');
	 * $q->field('salt');
	 * $q->query();                     # SELECT hash, salt
	 *                                  # FROM users
	 *                                  # WHERE 1 = 1
	 *
	 * $result = $q->get_object_list(); # Array
	 *                                  # (
	 *                                  #     [0] => stdClass Object
	 *                                  #     (
	 *                                  #         [hash] => e7ee2c83e86af973196fde64e1ab7178
	 *                                  #         [salt] => Jb9JbfrQoBRs7p0mNu3i7NSsC9AhuaCz
	 *                                  #     )
	 *                                  #
	 *                                  #     [1] => stdClass Object
	 *                                  #     (
	 *                                  #         [hash] => 0991b08461e5ce0ee0a038c104b5a6d3
	 *                                  #         [salt] => nLpUwvzSpD5yoqXtqjvhtqwhJUsMFh8P
	 *                                  #     )
	 *                                  # )
	 *
	 * @param $db_field
	 */
	public function field($db_field)
	{
		$this->field_list[] = $this->escape($db_field);
	}

	public function table($db_table)
	{
		$this->field_list[] = $this->escape($db_table) . '.*' . PHP_EOL;
	}

	public function join($table, $field, $field_equals = false, $target_table = null)
	{
		if ($field_equals === false)
		{
			$field_equals = $field;
		}

		if ($target_table === null)
		{
			$target_table = $this->from_table;
		}

		$this->left_join_tables[] = $table;
		$this->left_join_list[] = $table . ' ON ' . $target_table . '.' . $field . ' = ' . $table . '.' . $field_equals;
	}

	public function left_join($table, $field, $field_equals = false, $target_table = null)
	{
		$this->join($table, $field, $field_equals, $target_table);
	}

	public function right_join($table, $field, $field_equals = false)
	{
		if ($field_equals === false)
		{
			$field_equals = $field;
		}

		$this->right_join_tables[] = $table;
		$this->right_join_list[] = $table . ' ON ' . $this->from_table . '.' . $field . ' = ' . $table . '.' . $field_equals;
	}

	/**
	 * @en WHERE statement
	 * @ru Условие `WHERE`
	 *
	 * $q = new query('users');
	 * $q->where('id', 1);
	 * $q->query();                    # SELECT *
	 *                                 # FROM users
	 *                                 # WHERE id = 1
	 *
	 * $users = $q->get_object_list(); # Array
	 *                                 # (
	 *                                 #     [0] => stdClass Object
	 *                                 #     (
	 *                                 #         [id] => 1
	 *                                 #         [username] => root
	 *                                 #         [hash] => e7ee2c83e86af973196fde64e1ab7178
	 *                                 #         [salt] => Jb9JbfrQoBRs7p0mNu3i7NSsC9AhuaCz
	 *                                 #         [role_id] => 1
	 *                                 #     )
	 *                                 # )
	 *
	 * @param string $where
	 * @param bool $val
	 */
	public function where($where, $val = null)
	{
		$where = $this->escape($where);


		if ($val === true)
		{
			$this->where_list[] = $where . " = 'TRUE'";
		}
		else if ($val === false)
		{
			$this->where_list[] = $where . " = 'FALSE'";
		}
		else if ($val === null)
		{
			$this->where_list[] = $where;
		}
		else if (is_string($val))
		{
			$this->where_list[] = $where . " = '" . $this->escape($val) . "'";
		}
		else if (is_int($val) || is_float($val) || is_double($val))
		{
			$this->where_list[] = $where . ' = ' . $this->escape($val);
		}
		else
		{
			$this->where_list[] = $where . " = '" . $this->escape($val) . "'"; // default
		}
	}

	/**
	 * @en WHERE NOT statement
	 * @ru Условие `WHERE NOT`
	 *
	 *
	 * $q = new query('users');
	 * $q->where_not('id', 1);
	 * $q->query();                     # SELECT *
	 *                                  # FROM users
	 *                                  # WHERE id != 1
	 *
	 * $users = $q->get_object_list();  # Array
	 *                                  # (
	 *                                  #     [0] => stdClass Object
	 *                                  #     (
	 *                                  #         [id] => 2
	 *                                  #         [username] => manager
	 *                                  #         [hash] => 0991b08461e5ce0ee0a038c104b5a6d3
	 *                                  #         [salt] => nLpUwvzSpD5yoqXtqjvhtqwhJUsMFh8P
	 *                                  #         [role_id] => 2
	 *                                  #     )
	 *                                  # )
	 *
	 * @param $where
	 * @param $val
	 */
	public function where_not($where, $val)
	{
		$where = $this->escape($where);


		if ($val === true)
		{
			$this->where_list[] = $where . " != 'TRUE'";
		}
		else if ($val === false)
		{
			$this->where_list[] = $where . " != 'FALSE'";
		}
		else if ($val === null)
		{
			$this->where_list[] = $where;
		}
		else if (is_string($val))
		{
			$this->where_list[] = $where . " != '" . $this->escape($val) . "'";
		}
		else if (is_int($val) || is_float($val) || is_double($val))
		{
			$this->where_list[] = $where . ' != ' . $this->escape($val);
		}
		else
		{
			$this->where_list[] = $where . " != '" . $this->escape($val) . "'"; // default
		}
	}

	public function where_regexp($field, $val)
	{
		$this->where_list[] = $this->escape($field) . " REGEXP '" . $this->escape($val) . "'"; # default
	}

	/**
	 * @en OFFSET statement
	 * @ru Условие `OFFSET`
	 *
	 * $q = new query('users');
	 * $q->offset(10);
	 * $q->limit(5);
	 * $q->query(); # SELECT *
	 *              # FROM users
	 *              # WHERE 1 = 1
	 *              # LIMIT 10,5
	 *
	 * @param int $offset
	 */
	public function offset($offset)
	{
		$this->offset = (int) $offset;
	}

	/**
	 * @en LIMIT statement
	 * @ru Условие `LIMIT`
	 *
	 * $q = new query('users');
	 * $q->offset(10);
	 * $q->limit(5);
	 * $q->query(); # SELECT *
	 *              # FROM users
	 *              # WHERE 1 = 1
	 *              # LIMIT 10,5
	 *
	 * @param int $limit
	 */
	public function limit($limit)
	{
		$this->limit = (int) $limit;
	}


	/**
	 * @en ORDER BY and direction statements
	 * @ru Условия `ORDER BY` и направления
	 *
	 * $q = new query('users');
	 * $q->order_by('username');
	 * $q->query();                    # SELECT *
	 *                                 # FROM users
	 *                                 # WHERE 1 = 1
	 *                                 # ORDER BY username ASC
	 *
	 * $users = $q->get_object_list(); # Array
	 *                                 # (
	 *                                 #     [0] => stdClass Object
	 *                                 #     (
	 *                                 #         [id] => 2
	 *                                 #         [username] => manager
	 *                                 #         [hash] => 0991b08461e5ce0ee0a038c104b5a6d3
	 *                                 #         [salt] => nLpUwvzSpD5yoqXtqjvhtqwhJUsMFh8P
	 *                                 #         [role_id] => 2
	 *                                 #     )
	 *                                 #
	 *                                 #     [1] => stdClass Object
	 *                                 #     (
	 *                                 #         [id] => 1
	 *                                 #         [username] => root
	 *                                 #         [hash] => e7ee2c83e86af973196fde64e1ab7178
	 *                                 #         [salt] => Jb9JbfrQoBRs7p0mNu3i7NSsC9AhuaCz
	 *                                 #         [role_id] => 1
	 *                                 #     )
	 *                                 # )
	 *
	 *
	 * $q = new query('users');
	 * $q->order_by('username', 'DESC');
	 * $q->query();                    # SELECT *
	 *                                 # FROM users
	 *                                 # WHERE 1 = 1
	 *                                 # ORDER BY username DESC
	 *
	 * $users = $q->get_object_list(); # Array
	 *                                 # (
	 *                                 #     [0] => stdClass Object
	 *                                 #     (
	 *                                 #         [id] => 1
	 *                                 #         [username] => root
	 *                                 #         [hash] => e7ee2c83e86af973196fde64e1ab7178
	 *                                 #         [salt] => Jb9JbfrQoBRs7p0mNu3i7NSsC9AhuaCz
	 *                                 #         [role_id] => 1
	 *                                 #     )
	 *                                 #
	 *                                 #     [1] => stdClass Object
	 *                                 #     (
	 *                                 #         [id] => 2
	 *                                 #         [username] => manager
	 *                                 #         [hash] => 0991b08461e5ce0ee0a038c104b5a6d3
	 *                                 #         [salt] => nLpUwvzSpD5yoqXtqjvhtqwhJUsMFh8P
	 *                                 #         [role_id] => 2
	 *                                 #     )
	 *                                 # )
	 *
	 *
	 *
	 * @param        $field
	 * @param string $direction
	 */
	public function order_by($field, $direction = 'ASC')
	{
		if (!$field)
		{
			return;
		}

		$this->order_by = 'ORDER BY' . PHP_EOL . '  ' . $this->escape($field) . ' ' . $this->escape($direction);
	}

	public function group_by($field)
	{
		$this->group_by = $field;
	}

	/**
	 * @en Return complete SQL that will be executed with query() method
	 * @ru Возвращает конечный SQL, который подаётся на выполнение при вызове метода query()
	 *
	 * $q = new query('users');
	 * $q->field('hash');
	 * $q->field('salt');
	 * $q->where('username', 'root');
	 * $q->limit(5);
	 *
	 * $sql = $q->sql(); # SELECT hash, salt
	 *                   # FROM users
	 *                   # WHERE username = 'root'
	 *                   # LIMIT 5
	 *
	 * @return string
	 */
	public function sql()
	{
		$sql  = $this->sql_select();
		$sql .= $this->sql_from();
		$sql .= $this->sql_left_join();
		$sql .= $this->sql_right_join();
		$sql .= $this->sql_where();
		$sql .= $this->sql_group_by();
		$sql .= $this->sql_order_by();
		$sql .= $this->sql_limit();

		return $sql;
	}

	/**
	 * @en Return partical SQL query: SELECT section
	 * @ru Возвращает частичную секцию SQL запроса: SELECT
	 *
	 * $q = new query('users');
	 * $q->field('hash');
	 * $q->field('salt');
	 * $q->where('username', 'root');
	 * $q->limit(5);
	 *
	 * $sql = $q->sql_select(); # SELECT hash, salt
	 *
	 * @return string
	 */
	public function sql_select()
	{
		if (!empty($this->field_list))
		{
			return 'SELECT' . PHP_EOL . '  ' . implode(',' . PHP_EOL, $this->field_list) . PHP_EOL;
		}

		if (!empty($this->left_join_tables))
		{
			$table_columns = $this->columns($this->from_table);


			$select = 'SELECT' . PHP_EOL . '  ' . $this->from_table . '.*, ';

			foreach ($this->left_join_tables as $join_table)
			{
				$join_columns = $this->columns($join_table);

				$required_columns = array_diff($join_columns, $table_columns);


				foreach ($required_columns as $required_column)
				{
					$select .= PHP_EOL . $join_table . '.' . $required_column . ',';
				}

				$select  = char::remove_last($select);
				$select .= PHP_EOL;
			}

			return $select;
		}


		return 'SELECT' . PHP_EOL . '  *' . PHP_EOL;
	}

	/**
	 * @en Return partical SQL query: FROM section
	 * @ru Возвращает частичную секцию SQL запроса: FROM
	 *
	 * $q = new query('users');
	 * $q->field('hash');
	 * $q->field('salt');
	 * $q->where('username', 'root');
	 * $q->limit(5);
	 *
	 * $sql = $q->sql_from(); # FROM users
	 *
	 * @return string
	 */
	public function sql_from()
	{
		if (!empty($this->from_table))
		{
			return 'FROM' . PHP_EOL . '  ' . $this->from_table . PHP_EOL;
		}

		return '';
	}

	/**
	 * @en Return partical SQL query: LEFT JOIN section
	 * @ru Возвращает частичную секцию SQL запроса: LEFT JOIN
	 *
	 * @return string
	 */
	public function sql_left_join()
	{
		$result = '';

		if (!empty($this->left_join_list))
		{
			foreach ($this->left_join_list as $join)
			{
				$result .= 'LEFT JOIN' . PHP_EOL . '  ' . $join . PHP_EOL;
			}
		}

		return $result;
	}

	/**
	 * @en Return partical SQL query: RIGHT JOIN section
	 * @ru Возвращает частичную секцию SQL запроса: RIGHT JOIN
	 *
	 * @return string
	 */
	public function sql_right_join()
	{
		if (!empty($this->right_join_list))
		{
			return 'RIGHT JOIN' . PHP_EOL . '  ' . implode(PHP_EOL, $this->right_join_list) . PHP_EOL;
		}

		return '';
	}

	/**
	 * @en Return partical SQL query: WHERE section
	 * @ru Возвращает частичную секцию SQL запроса: WHERE
	 *
	 * $q = new query('users');
	 * $q->field('hash');
	 * $q->field('salt');
	 * $q->where('username', 'root');
	 * $q->limit(5);
	 *
	 * $sql = $q->sql_from(); # WHERE username = 'root'
	 *
	 * @return string
	 */
	public function sql_where()
	{
		if (empty($this->where_list))
		{
			return 'WHERE' . PHP_EOL . '  1 = 1' . PHP_EOL;
		}

		return 'WHERE' . PHP_EOL . '  ' . implode(PHP_EOL . 'AND' . PHP_EOL . '  ', $this->where_list) . PHP_EOL;
	}

	public function sql_order_by()
	{
		return $this->order_by . PHP_EOL;
	}

	public function sql_group_by()
	{
		if ($this->group_by)
		{
			return 'GROUP BY' . PHP_EOL . '  ' . $this->group_by . PHP_EOL;
		}

		return '';
	}

	public function sql_limit()
	{
		if ($this->limit !== null)
		{
			if ($this->offset !== null)
			{
				return 'LIMIT' . PHP_EOL . '  ' . $this->offset . ',' . $this->limit . PHP_EOL;
			}

			return 'LIMIT' . PHP_EOL . '  ' . $this->limit . PHP_EOL;
		}

		return '';
	}

	/**
	 * @en Execute SQL query
	 * @ru Выполнение построенного SQL запроса
	 *
	 * $q = new query('users');
	 * $q->offset(10);
	 * $q->limit(5);
	 * $q->query(); # SELECT *
	 *              # FROM users
	 *              # WHERE 1 = 1
	 *              # LIMIT 10,5
	 */
	public function query()
	{
		$sql = $this->sql();

		$this->result = $this->database->query($sql);
	}

	/**
	 * @en Get query result as an object list
	 * @ru Получить ответ из базы данных в виде массива объектов
	 *
	 * $q = new query('users');
	 * $q->field('hash');
	 * $q->field('salt');
	 * $q->query();                     # SELECT hash, salt
	 *                                  # FROM users
	 *                                  # WHERE 1 = 1
	 *
	 * $result = $q->get_object_list(); # Array
	 *                                  # (
	 *                                  #     [0] => stdClass Object
	 *                                  #     (
	 *                                  #         [hash] => e7ee2c83e86af973196fde64e1ab7178
	 *                                  #         [salt] => Jb9JbfrQoBRs7p0mNu3i7NSsC9AhuaCz
	 *                                  #     )
	 *                                  #
	 *                                  #     [1] => stdClass Object
	 *                                  #     (
	 *                                  #         [hash] => 0991b08461e5ce0ee0a038c104b5a6d3
	 *                                  #         [salt] => nLpUwvzSpD5yoqXtqjvhtqwhJUsMFh8P
	 *                                  #     )
	 *                                  # )
	 *
	 * @return array
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
	 * $q = new query('users');
	 * $q->field('hash');
	 * $q->field('salt');
	 * $q->query();                # SELECT hash, salt
	 *                             # FROM users
	 *                             # WHERE 1 = 1
	 *
	 * $result = $q->get_object(); # stdClass Object
	 *                             # (
	 *                             #     [hash] => e7ee2c83e86af973196fde64e1ab7178
	 *                             #     [salt] => Jb9JbfrQoBRs7p0mNu3i7NSsC9AhuaCz
	 *                             # )
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

	/**
	 * @en SQL query escaping
	 * @ru Экранирование части SQL запроса
	 *
	 * @param mixed $var
	 *
	 * @return string
	 */
	public function escape($var)
	{
		return $this->database->escape($var);
	}
}