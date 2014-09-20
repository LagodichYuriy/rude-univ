<?

namespace rude;

class template_image
{
	public static function logo()   { return static::custom('logo.png');   }
	public static function yes()    { return static::custom('yes.png');    }
	public static function sync()   { return static::custom('sync.png');   }
	public static function save()   { return static::custom('save.png');   }
	public static function remove() { return static::custom('remove.png'); }
	public static function pdf()    { return static::custom('pdf.png');    }
	public static function ok()     { return static::custom('ok.png');     }
	public static function help()   { return static::custom('help.png');   }
	public static function error()  { return static::custom('error.png');  }
	public static function edit()   { return static::custom('edit.png');   }
	public static function closed() { return static::custom('closed.png'); }
	public static function add()    { return static::custom('add.png');    }
	public static function search() { return static::custom('search.png'); }

	public static function custom($name)
	{
		return '<img src="' . template_url::image($name) . '" />';
	}
}