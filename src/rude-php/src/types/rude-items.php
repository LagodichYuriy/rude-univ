<?

namespace rude;

/**
 * @category types
 */
class items
{
	public static function get($array, $n, $default = null)
	{
		return get($n - 1, $array, $default);
	}

	/**
	 * @en Get the first element of an array
	 * @ru Возвращает первый (первые) элементы массива
	 *
	 * @param array $array
	 * @param int $n
	 *
	 * @return mixed
	 */
	public static function first($array, $n = 1)
	{
		if ($n != 1)
		{
			$i = 1;

			$buffer = null;

			foreach ($array as $item)
			{
				$buffer[] = $item;

				if ($i++ >= $n)
				{
					break;
				}
			}

			return $buffer;
		}

		return reset($array);
	}

	/**
	 * @en Get the last element of an array
	 * @ru Возвращает последний (последние) элементы массива
	 *
	 * @param array $array
	 * @param int $n
	 *
	 * @return mixed
	 */
	public static function last($array, $n = 1)
	{
		if ($n != 1)
		{
			$i = 1;

			$buffer = null;

			$array = array_reverse($array);

			foreach ($array as $item)
			{
				$buffer[] = $item;

				if ($i++ >= $n)
				{
					break;
				}
			}

			return $buffer;
		}

		return end($array);
	}

	/**
	 * @en Pick one random entry out of an array
	 * @ru Выбирает случайный элемент из массива
	 *
	 * @param array $array
	 *
	 * @return mixed
	 */
	public static function rand($array)
	{
		return $array[array_rand($array)];
	}

	/**
	 * @en Same as trim(), just for all elements of the array
	 * @ru Тоже самое, что и trim(), только для всех элементов в массиве
	 *
	 * @param array $array
	 *
	 * @return array
	 */
	public static function trim($array)
	{
		return array_map('trim', $array);
	}

	/**
	 * @en Count all occurrences of specified arrays inside array
	 * @ru Возвращает количество копий определённых элементов в массиве
	 *
	 * $haystack = array('a', 'b', 'f', 'r', 'b', 'v', 'r', 'b', 't', 'a');
	 * $needle = array('a', 'b');
	 *
	 * $count = array_count($needle, $haystack); # int(2)
	 *
	 * @param array $needle
	 * @param array $haystack
	 *
	 * @return int
	 */
	public static function count($needle, $haystack)
	{
		$count = INF;
		$array = array_count_values($haystack);

		foreach ($needle as $item)
		{
			if (!isset($array[$item]))
			{
				return 0;
			}

			$count = min($count, $array[$item]);
		}

		return (int) $count;
	}

	/**
	 * @en Erase specified items inside array
	 * @ru Убирает полные копии указанных элементов из массива
	 *
	 * $haystack = array('a', 'b', 'f', 'r', 'b', 'v', 'r', 'b', 't', 'a');
	 * $needle = array('a', 'b');
	 *
	 * $result = array_erase($needle, $haystack); # array('f', 'r', 'v', 'r', 'b', 't');
	 *
	 * @param array $needle
	 * @param array $haystack
	 * @param int $count
	 *
	 * @return mixed
	 */
	public static function erase($needle, $haystack, $count = null)
	{
		if ($count === null)
		{
			$count = items::count($needle, $haystack);
		}

		if (!$count)
		{
			return $haystack;
		}


		$result = $haystack;

		foreach ($needle as $item)
		{
			$index = array_keys($result, $item);

			for ($i = 0; $i < $count; $i++)
			{
				unset($result[$index[$i]]);
			}
		}

		return $result;
	}

	/**
	 * @en Generating all permutations of a given array
	 * @ru Получение всех возможны вариантов перестановок элементов массива
	 *
	 * $array = array('AAA', 'BBB', 'CCC');
	 *
	 * $result = arrays::permutation($array); # Array
	 *                                        # (
	 *                                        #     [0] => Array
	 *                                        #     (
	 *                                        #         [0] => AAA
	 *                                        #         [1] => BBB
	 *                                        #         [2] => CCC
	 *                                        #     )
	 *                                        #
	 *                                        #     [1] => Array
	 *                                        #     (
	 *                                        #         [0] => AAA
	 *                                        #         [1] => CCC
	 *                                        #         [2] => BBB
	 *                                        #     )
	 *                                        #
	 *                                        #     [2] => Array
	 *                                        #     (
	 *                                        #         [0] => BBB
	 *                                        #         [1] => CCC
	 *                                        #         [2] => AAA
	 *                                        #     )
	 *                                        #
	 *                                        #     [3] => Array
	 *                                        #     (
	 *                                        #         [0] => BBB
	 *                                        #         [1] => AAA
	 *                                        #         [2] => CCC
	 *                                        #     )
	 *                                        #
	 *                                        #     [4] => Array
	 *                                        #     (
	 *                                        #         [0] => CCC
	 *                                        #         [1] => AAA
	 *                                        #         [2] => BBB
	 *                                        #     )
	 *                                        #
	 *                                        #     [5] => Array
	 *                                        #     (
	 *                                        #         [0] => CCC
	 *                                        #         [1] => BBB
	 *                                        #         [2] => AAA
	 *                                        #     )
	 *                                        # )
	 *
	 * @param array $array
	 *
	 * @return array
	 */
	public static function permutation($array)
	{
		$results = array();

		if (count($array) == 1)
		{
			$results[] = $array;
		}
		else
		{
			for ($i = 0; $i < count($array); $i++)
			{
				$first = array_shift($array);

				$subresults = items::permutation($array);

				array_push($array, $first);

				foreach ($subresults as $subresult)
				{
					$results[] = array_merge(array($first), $subresult);
				}
			}
		}

		return $results;
	}
}