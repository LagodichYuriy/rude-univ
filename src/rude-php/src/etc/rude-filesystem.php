<?

namespace rude;

class filesystem
{
	/**
	 * @en Read the file
	 * @ru Читает файл
	 *
	 * $result = filesystem::read('file.txt'); # string(18) "text from the file"
	 *
	 * @param string $file_path Path to the file
	 *
	 * @return string
	 */
	public static function read($file_path)
	{
		return file_get_contents($file_path);
	}

	/**
	 * @en Write the file
	 * @ru Пишет в файл
	 *
	 * $file_path = '/srv/http/file.txt';
	 *
	 * $is_written = filesystem::write($file_path, 'Hello!');   # bool(true) on success and bool(false) otherwise
	 *
	 * @param string $file_path Path to the file
	 * @param mixed $data String, array or stream resource
	 * @param int $flags
	 *
	 * @return bool
	 */
	public static function write($file_path, $data, $flags = 0)
	{
		if (file_put_contents($file_path, $data, $flags) !== false)
		{
			return true;
		}

		return false;
	}

	/**
	 * @en Rewrite the file
	 * @ru Перезапись файла
	 *
	 * $file_path = '/srv/http/file.txt';
	 *
	 * $is_written   = filesystem::write($file_path, 'Hello!');   # file data: string(6) "Hello!"
	 * $is_rewritten = filesystem::rewrite($file_path, 'Sandy!'); # file data: string(6) "Sandy!"
	 *
	 * @param string $file_path Path to the file
	 * @param mixed $data String, array or stream resource
	 * @param int $flags
	 *
	 * @return bool
	 */
	public static function rewrite($file_path, $data, $flags = 0)
	{
		return filesystem::write($file_path, $data, $flags);
	}

	/**
	 * @en Append content to existing file
	 * @ru Добавление к файлу
	 *
	 * $is_written  = filesystem::write($file_path, 'Hello!');   # file data: string(6) "Sandy!"
	 * $is_appended = filesystem::append($file_path, ' Dandy!'); # file data: string(13) "Sandy! Dandy!"
	 *
	 * @param string $file_path Path to the file
	 * @param mixed $data String, array or stream resource
	 *
	 * @return bool
	 */
	public static function append($file_path, $data)
	{
		return filesystem::write($file_path, $data, FILE_APPEND);
	}


	/**
	 * @en Copies file
	 * @ru Копирует файл
	 *
	 * $result = filesystem::copy('file.txt', 'file-copy.txt'); # bool(true) on success and bool(false) otherwise
	 *
	 * @param string $path_from
	 * @param string $path_to
	 *
	 * @return bool
	 */
	public static function copy($path_from, $path_to)
	{
		return copy($path_from, $path_to);
	}

	/**
	 * @en Rename a file or directory
	 * @ru Переименовывает файл или директорию
	 *
	 * $result = filesystem::move('file.txt', 'file-new.txt'); # bool(true) on success and bool(false) otherwise
	 *
	 * @param string $path_from
	 * @param string $path_to
	 *
	 * @return bool
	 */
	public static function rename($path_from, $path_to)
	{
		return filesystem::move($path_from, $path_to);
	}

	/**
	 * @en Moves a file or directory
	 * @ru Перемещает файл или директорию
	 *
	 * $result = filesystem::move('file.txt', 'file-new.txt'); # bool(true) on success and bool(false) otherwise
	 *
	 * @param string $path_from
	 * @param string $path_to
	 *
	 * @return bool
	 */
	public static function move($path_from, $path_to)
	{
		return rename($path_from, $path_to);
	}

	/**
	 * @en Gets file or directory size in bytes
	 * @ru Получает размер файла или директории в байтах
	 *
	 * $file_size = filesystem::size('file.txt');  # int(18)         # 18 bytes
	 *
	 * $dir_size = filesystem::size('/srv/http/'); # int(8168620229) # 7790.2 megabytes
	 *
	 * @param string $path File path
	 *
	 * @return int
	 */
	public static function size($path)
	{
		if (filesystem::is_file($path))
		{
			return filesize($path);
		}


		$size = 0;

		foreach (new \RecursiveIteratorIterator(new \RecursiveDirectoryIterator($path)) as $file)
		{
			/** @var \SplFileInfo $file */

			$size += $file->getSize();
		}

		return $size;
	}

	/**
	 * @en Calculate the SHA-1 hash of a file
	 * @ru Вычисляет SHA-1 хэш файла
	 *
	 * $result = filesystem::sha1('file.txt'); # string(40) "f8de2ea7a87ac87f97dc61110de03234f176454c"
	 *
	 * @param string $path File path
	 *
	 * @return string
	 */
	public static function sha1($path)
	{
		return sha1_file($path);
	}

	/**
	 * @en Calculate the MD5 hash of a file
	 * @ru Вычисляет MD5 хэш файла
	 *
	 * $result = filesystem::md5('file.txt'); # string(32) "5cbdabd2d7f9cf5a193f45e3c57ec062"
	 *
	 * @param string $path File path
	 *
	 * @return string
	 */
	public static function md5($path)
	{
		return md5_file($path);
	}

	/**
	 * @en Create the file
	 * @ru Создание файла
	 *
	 * $file_path = '/srv/http/file.txt';
	 *
	 * $is_created   = filesystem::create_file($file_path);       # bool(true) on success and bool(false) otherwise
	 *
	 * @param string $path
	 *
	 * @return bool
	 */
	public static function create_file($path)
	{
		return touch($path);
	}

	/**
	 * @en Create the directory
	 * @ru Создание директории
	 *
	 * @param string $path
	 * @param int $mode
	 * @param bool $recursive
	 *
	 * @return bool
	 */
	public static function create_directory($path, $mode = 0755, $recursive = false)
	{
		return mkdir($path, $mode, $recursive);
	}

	/**
	 * @en Checks whether a file or directory exists
	 * @ru Проверяет, существует ли указанный файл или директория
	 *
	 * @param string $path
	 *
	 * @return bool
	 */
	public static function is_exists($path)
	{
		return file_exists($path);
	}

	/**
	 * @en Tells whether the filename is a regular file
	 * @ru Проверяет, является ли структура по указанному пути файлом
	 *
	 * $is_file = filesystem::is_file('file.txt');   # bool(true)
	 * $is_file = filesystem::is_file('/srv/http/'); # bool(false)
	 *
	 * @param string $path
	 *
	 * @return bool
	 */
	public static function is_file($path)
	{
		return is_file($path);
	}

	/**
	 * @en Tells whether the filename is a directory
	 * @ru Проверяет, является ли структура по указанному пути директорией
	 *
	 * $is_directory = filesystem::is_file('file.txt');   # bool(false)
	 * $is_directory = filesystem::is_file('/srv/http/'); # bool(true)
	 *
	 * @param string $path
	 *
	 * @return bool
	 */
	public static function is_dir($path)
	{
		return is_dir($path);
	}

	/**
	 * @en Change file extension
	 * @ru Изменяет расширение файла
	 *
	 * $result = filesystem::change_extension('my.txt', 'html'); # bool(true) on success and bool(false) otherwise
	 *
	 * @param string $file_path
	 * @param string $new_extension New extension (dot is not required)
	 *
	 * @return string
	 */
	public static function change_extension($file_path, $new_extension)
	{
		$new_path = filesystem::file_dir($file_path) . DIRECTORY_SEPARATOR . filesystem::file_name($file_path) . '.' . $new_extension;

		return filesystem::rename($file_path, $new_path);
	}

	private static function file_part($path, $part)
	{
		$path_parts = pathinfo($path);

		if (isset($path_parts[$part]))
		{
			return $path_parts[$part];
		}

		return null;
	}

	/**
	 * @en File parts: directory name
	 * @ru Имя директории
	 *
	 * $file_path = '/srv/http/backup.zip';
	 *
	 * $result = filesystem::file_dir($file_path); # string(9) "/srv/http"
	 *
	 * @param string $path Path to the file (the actual existence of a file does not necessary)
	 *
	 * @return string
	 */
	public static function file_dir($path)
	{
		return filesystem::file_part($path, 'dirname');
	}

	/**
	 * @en File parts: basename
	 * @ru Полное имя файла
	 *
	 * $file_path = '/srv/http/backup.zip';
	 *
	 * $result = filesystem::file_basename($file_path); # string(10) "backup.zip"
	 *
	 * @param string $path Path to the file (the actual existence of a file does not necessary)
	 *
	 * @return string
	 */
	public static function file_basename($path)
	{
		return filesystem::file_part($path, 'basename');
	}

	/**
	 * @en File parts: extension
	 * @ru Расширение файла
	 *
	 * $file_path = '/srv/http/backup.zip';
	 *
	 * $result = filesystem::file_extension($file_path); # string(3) "zip"
	 *
	 * @param string $path Path to the file (the actual existence of a file does not necessary)
	 *
	 * @return string
	 */
	public static function file_extension($path)
	{
		return filesystem::file_part($path, 'extension');
	}

	/**
	 * @en File parts: name (without extension)
	 * @ru Имя файла бег расширения
	 *
	 * $file_path = '/srv/http/backup.zip';
	 *
	 * $result = filesystem::file_name($file_path); # string(6) "backup"
	 *
	 * @param string $path Path to the file (the actual existence of a file does not necessary)
	 *
	 * @return string
	 */
	public static function file_name($path)
	{
		return filesystem::file_part($path, 'filename');
	}

	/**
	 * @en Gets file modification time as Unix timestamp integer value
	 * @ru Возвращает отметку времени последней модификации файла
	 *
	 * $result = filesystem::timestamp('file.txt'); # int(1409333664) # Fri, 29 Aug 2014 17:34:24 GMT (converted from unixtime)
	 *
	 * @param string $path Path to the file
	 *
	 * @return int
	 */
	public static function timestamp($path)
	{
		return filemtime($path);
	}

	/**
	 * @en Archive, compressed with Zip
	 * @ru Создаёт Zip архив директории
	 *
	 * $result = filesystem::zip('/srv/http/site.com/', '/srv/http/backup.zip'); # bool(true) on success and bool(false) otherwise
	 *
	 * @param string $path Any directory (note: symlinks in subdirectories will be ignored)
	 * @param string $destination Zipped archive destination
	 *
	 * @return bool
	 */
	public static function zip($path, $destination)
	{
		if (!extension_loaded('zip') || !file_exists($path))
		{
			return false;
		}

		$zip = new \ZipArchive();

		if (!$zip->open($destination, \ZipArchive::CREATE))
		{
			return false;
		}

		$path = str_replace('\\', '/', realpath($path));

		if (is_dir($path) === true)
		{
			$files = new \RecursiveIteratorIterator(new \RecursiveDirectoryIterator($path), \RecursiveIteratorIterator::SELF_FIRST);

			foreach ($files as $file)
			{
				$file = str_replace('\\', '/', $file);

				# Ignore "." and ".." folders
				if (in_array(substr($file, strrpos($file, '/') + 1), array('.', '..')))
				{
					continue;
				}


				$file = realpath($file);

				if (is_dir($file) === true)
				{
					$zip->addEmptyDir(str_replace($path . '/', '', $file . '/'));
				}
				else if (is_file($file) === true)
				{
					$zip->addFromString(str_replace($path . '/', '', $file), file_get_contents($file));
				}
			}
		}
		else if (is_file($path) === true)
		{
			$zip->addFromString(basename($path), file_get_contents($path));
		}

		return $zip->close();
	}

	/**
	 * @en Find files
	 * @ru Поиск файлов
	 *
	 * # listing all the files in a directory and subdirectories:
	 *
	 * $result = filesystem::scandir('./src/lib/'); # Array
	 *                                              # (
	 *                                              #     [0] => src/lib/include.php
	 *                                              #     [1] => src/lib/README.md
	 *                                              #     [2] => src/lib/src/etc/rude-system.php
	 *                                              #     [3] => src/lib/src/etc/rude-globals.php
	 *                                              #     [4] => src/lib/src/etc/rude-measures.php
	 *                                              #     [5] => src/lib/src/etc/rude-visitor.php
	 *                                              #     [6] => src/lib/src/etc/rude-date.php
	 *                                              #     [7] => src/lib/src/etc/rude-url.php
	 *                                              #     [8] => src/lib/src/etc/rude-html.php
	 *                                              #     [9] => src/lib/src/etc/rude-crypt.php
	 *                                              #     [10] => src/lib/src/etc/rude-cookies.php
	 *                                              #     [11] => src/lib/src/etc/rude-math.php
	 *                                              #     [12] => src/lib/src/etc/rude-autoload.php
	 *                                              #     [13] => src/lib/src/etc/rude-headers.php
	 *                                              #     [14] => src/lib/src/etc/rude-speedtest.php
	 *                                              #     [15] => src/lib/src/etc/rude-curl.php
	 *                                              #     [16] => src/lib/src/etc/rude-filesystem.php
	 *                                              #     [17] => src/lib/src/etc/rude-session.php
	 *                                              #
	 *                                              #     ... and 164 files more
	 *                                              # )
	 *
	 *
	 * # listing all the files in a directory and subdirectories with '.md' file extension:
	 *
	 * $result = filesystem::scandir('src/lib', 'md'); # Array
	 *                                                 # (
	 *                                                 #     [0] => src/lib/README.md
	 *                                                 #     [1] => src/lib/LICENSE.md
	 *                                                 #     [2] => src/lib/NOTICE.md
	 *                                                 # )
	 *
	 *
	 * # listing all the files in a directory but not in subdirectories with '.php' file extension:
	 *
	 * $result = filesystem::search_files('src/lib', 'php', false); # Array
	 *                                                              # (
	 *                                                              #     [0] => include.php
	 *                                                              # )
	 *
	 *
	 *
	 * @param string $path
	 * @param string $extension
	 * @param bool $recursively Set 'true' if you need to gather files from subdirectories
	 *
	 * @return array
	 */
	public static function search_files($path, $extension = null, $recursively = true)
	{
		$file_list = null;

		if ($recursively === true)
		{
			$objects = new \RecursiveIteratorIterator(new \RecursiveDirectoryIterator($path), \RecursiveIteratorIterator::SELF_FIRST);


			foreach ($objects as $name => $object)
			{
				$file_list[] = $name;
			}
		}
		else
		{
			$file_list = scandir($path);
		}


		$result = array();

		if ($file_list)
		{
			foreach ($file_list as $file_path)
			{
				if (filesystem::is_dir($file_path))
				{
					continue; # exclude directories
				}

				if ($extension === null)
				{
					$result[] = $file_path;

					continue;
				}

				if (filesystem::file_extension($file_path) == $extension)
				{
					$result[] = $file_path;
				}
			}
		}

		return $result;
	}

	/**
	 * @en Removes directory or file
	 * @ru Удаляет директорию или файл
	 *
	 * $result = filesystem::remove('/srv/http/directory/'); # bool(true) on success and bool(false) otherwise
	 * $result = filesystem::remove('/srv/http/file.txt');   # bool(true) on success and bool(false) otherwise
	 *
	 * @param string $path
	 * @param bool $recursively
	 *
	 * @return bool
	 */
	public static function remove($path, $recursively = false)
	{
		if ($recursively !== false)
		{
			foreach (new \RecursiveIteratorIterator(new \RecursiveDirectoryIterator($path, \FilesystemIterator::SKIP_DOTS), \RecursiveIteratorIterator::CHILD_FIRST) as $item)
			{
				/** @var $item \DirectoryIterator */
				$item->isDir() ? rmdir($item->getPathname()) : unlink($item->getPathname());
			}

			return rmdir($path);
		}

		if (is_file($path))
		{
			return unlink($path);
		}

		if (is_dir($path))
		{
			return rmdir($path);
		}

		return false;
	}
}