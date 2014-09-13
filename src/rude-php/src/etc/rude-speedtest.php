<?

namespace rude;

class speedtest
{
	public $time_start = 0;
	public $time_end   = 0;

	public function __construct($auto_start = false)
	{
		if ($auto_start !== false)
		{
			$this->start();
		}
	}

	public function time_current()
	{
		return microtime(true);
	}

	public function time_global($precision = 4)
	{
		return round((microtime(true) - $_SERVER['REQUEST_TIME_FLOAT']), $precision);
	}

	public function start()
	{
		$this->time_start = $this->time_current();
	}

	public function end()
	{
		$this->time_end = $this->time_current();
	}

	public function result($precision = 4)
	{
		return round($this->time_end - $this->time_start, $precision);
	}

	public function reset()
	{
		$this->time_start = 0;
		$this->time_end   = 0;
	}
}

