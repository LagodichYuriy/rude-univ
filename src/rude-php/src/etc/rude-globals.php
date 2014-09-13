<?

/**
 * @en Getting an item from an array. Designed for usage with $_REQUEST by default
 * @ru Получение элемента из именнованного массива. Предполагается преимущественное использование с массивом $_REQUEST по умолчанию
 *
 * # $_REQUEST parse (default usage)
 *
 * debug($_REQUEST);    # Array
 *                      # (
 *                      #     [user] => Sandy
 *                      #     [host] => localhost
 *                      #     [pass] => XHIIGygSsr
 *                      # )
 *
 * $user = get('user'); # string(5) "Sandy"
 * $host = get('host'); # string(9) "localhost"
 * $pass = get('pass'); # string(10) "XHIIGygSsr"
 *
 *
 * # array parse (advanced usage)
 *
 * $array = array('username' => 'Sandy', 'password' => "XHIIGygSsr");
 *
 * $username = get('username', $array); # string(5) "Sandy"
 * $password = get('password', $array); # string(10) "XHIIGygSsr"
 *
 *
 * # you can also specify a default value for return if the specified array element not found
 *
 * $undefined = get('undefined', $array);              # NULL
 * $undefined = get('undefined', $array, 1);           # int(1)
 * $undefined = get('undefined', $array, false);       # bool(false)
 * $undefined = get('undefined', $array, "not found"); # string(9) "not found"
 *
 * @param mixed $what
 * @param mixed $src
 * @param mixed $default
 *
 * @return mixed
 */
function get($what, $src = null, $default = null)
{
	if ($src === null)
	{
		$src = $_REQUEST;
	}

	if (!empty($src[$what]))
	{
		return $src[$what];
	}

	return $default;
}


/**
 * @en Human-readable variable dumper
 * @ru Человеко-читаемый вывод информации о переменной
 *
 * $int = 12345;
 *
 * debug($int);                           # 12345                                       # print_r alias
 * debug($int, true);                     # int(12345)                                  # var_dump alias
 * debug($int, false, 'number');          # [number]: 12345                             # print_r + title
 * debug($int, false, 'number', true);    # [number]: 12345 (12345 B; 12.06 KB; 0.01MB) # print_r + title + size
 * debug($int, false, 'number', true, 1); # [number]: 12345 (12345 B; 12.1 KB; 0MB)     # print_r + title + size + precision
 *
 *
 * $array = array('AAA', 'BBB', 'CCC');
 *
 * debug($array);                         # Array
 *                                        # (
 *                                        #     [0] => AAA
 *                                        #     [1] => BBB
 *                                        #     [2] => CCC
 *                                        # )
 *
 *
 * $object = new \stdClass();
 * $object->int = $int;
 * $object->array = $array;
 *
 * debug($object);                        # stdClass Object
 *                                        # (
 *                                        #     [int] => 12345
 *                                        #     [array] => Array
 *                                        #         (
 *                                        #             [0] => AAA
 *                                        #             [1] => BBB
 *                                        #             [2] => CCC
 *                                        #         )
 *                                        # )
 *
 * @param mixed $var
 * @param bool $type_info
 * @param string $title
 * @param bool $show_size
 * @param int $precision
 */
function debug($var, $type_info = false, $title = null, $show_size = false, $precision = 2)
{
	?><pre><? if ($title !== null) { ?><b>[<?= $title ?>]:</b> <? } if ($type_info) { var_dump($var); } else { print_r($var); } if ($show_size) { if (is_int($var)) { $size = $var; } else { $size = strlen($var); } ?> (<?= $size ?> B; <?= round($size / 1024, $precision) ?> KB; <?= round($size / 1024 / 1024, $precision) ?>MB)<? } ?></pre><?
}