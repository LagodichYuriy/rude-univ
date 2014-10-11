<?

namespace rude;

# helps to increment values in the fields

/**
 * @category database
 */
class iquery
{
	/** @var database  */
	private $database = null;         // database class

	private $update_table = null;

	private $where_list = null;       // [required] WHERE
	private $inc_list = null;         // [required] SET

	/** @var \mysqli_result */
	private $result = null;           // query result

	public function __construct($update_table)
	{
		$this->database = new database();

		$this->update_table = $this->escape($update_table);
	}

	public function inc($key)
	{
		$this->inc_list[] = $this->escape($key);
	}

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
			$this->where_list[] = $where . " = '" . $this->escape($val) . "'"; # default
		}
	}

	public function sql()
	{
		$sql  = $this->sql_inc();
		$sql .= $this->sql_where();

		return $sql;
	}

	public function sql_inc()
	{
		$sql  = 'UPDATE ' . $this->update_table . PHP_EOL;
		$sql .= 'SET ';

		foreach ($this->inc_list as $inc)
		{
			$sql .= $inc . ' = ' . $inc . ' + 1' . PHP_EOL;
		}

		return $sql;
	}

	public function sql_where()
	{
		return 'WHERE ' . implode(' AND ', $this->where_list) . PHP_EOL;
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