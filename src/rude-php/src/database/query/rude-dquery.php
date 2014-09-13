<?

namespace rude;

/**
 * @category database
 */
class dquery
{
	/** @var database  */
	private $database = null;         // database class


	private $delete_table = null;     // [required] DELETE FROM
	private $where_list = null;       // [required] WHERE
	private $limit = null;            // [optional] LIMIT

	/** @var \mysqli_result */
	private $result = null;           // query result

	//"DELETE FROM `university`.`univ_users` WHERE `univ_users`.`id` = 13"?

	public function __construct($delete_table)
	{
		$this->database = new database();

		$this->delete_table = $this->escape($delete_table);
	}

	public function columns()
	{
		return $this->database->columns($this->delete_table);
	}

	public function where($where, $val = false)
	{
		$where = $this->escape($where);

		if ($val === false)
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
			$this->where_list[] = $where . " = '" . $this->escape($val) . "'"; # default
		}
	}

	public function limit($limit)
	{
		$this->limit = (int) $limit;
	}


	public function sql()
	{
		$sql  = '';

		$sql .= $this->sql_from();
		$sql .= $this->sql_where();
		$sql .= $this->sql_limit();

		return $sql;
	}

	public function sql_from()
	{
		return 'DELETE FROM ' . $this->delete_table . PHP_EOL;
	}

	public function sql_where()
	{
		if (empty($this->where_list))
		{
			return 'WHERE 1 = 1' . PHP_EOL;
		}

		return 'WHERE ' . implode(' AND ', $this->where_list) . PHP_EOL;
	}

	public function sql_limit()
	{
		if (!empty($this->limit))
		{
			return 'LIMIT ' .  $this->limit;
		}

		return '';
	}

	public function query()
	{
		$sql = $this->sql();

		$this->result = $this->database->query($sql);
	}

	public function escape($var)
	{
		return $this->database->escape($var);
	}
}

