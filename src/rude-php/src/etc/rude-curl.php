<?

namespace rude;

class curl
{
	/**
	 * @en CURL file_get_contents() equivalent with timeout settings
	 * @ru Эквивалент на CURL для функции file_get_contents() с наличием таймаута
	 *
	 * $html = curl::file_get_contents('http://site.com', 3);
	 *
	 * @param string $url
	 * @param int $timeout
	 *
	 * @return mixed
	 */
	public static function file_get_contents($url, $timeout = 3)
	{
		$ch = curl_init();

		curl_setopt($ch, CURLOPT_AUTOREFERER, true);
		curl_setopt($ch, CURLOPT_HEADER, 0);
		curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
		curl_setopt($ch, CURLOPT_URL, $url);
		curl_setopt($ch, CURLOPT_FOLLOWLOCATION, true);
		curl_setopt($ch, CURLOPT_CONNECTTIMEOUT, $timeout);

		$data = curl_exec($ch);

		curl_close($ch);

		return $data;
	}
}