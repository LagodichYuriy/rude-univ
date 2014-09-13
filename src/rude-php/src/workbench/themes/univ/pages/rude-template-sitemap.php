<?

namespace rude;

class template_sitemap
{
	public static function xml()
	{
		                                        ##########
		$xml  = static::xml_header();           # header #
		                                        ##########

		                                        ############
		$xml .= static::xml_url(RUDE_URL_SITE); # homepage #
		                                        ############

//
//		$globals = functions::get_globals();
//
//		foreach ($globals as $global)
//		{
//			                                                                   ###########
//			$xml .= static::xml_url(template_url::link_global($global->name)); # globals #
//			                                                                   ###########
//		}
//
//
//		$classes = classes::get();
//
//		foreach ($classes as $class)
//		{                                                                    ###########
//			$xml .= static::xml_url(template_url::link_class($class->name)); # classes #
//		}                                                                    ###########
//
//
//		$functions = functions::get();
//
//		foreach ($functions as $function)
//		{
//			foreach ($classes as $class)
//			{
//				if ($function->class_id == $class->id)
//				{                                                                                        #############
//					$xml .= static::xml_url(template_url::link_function($class->name, $function->name)); # functions #
//					                                                                                     #############
//					break;
//				}
//			}
//		}
//
//									  ##########
//		$xml .= static::xml_footer(); # footer #
//		                              ##########
		return $xml;
	}

	public static function xml_header()
	{
		return '<?xml version="1.0" encoding="UTF-8"?>' . PHP_EOL . '<urlset xmlns="http://www.sitemaps.org/schemas/sitemap/0.9" xmlns:image="http://www.google.com/schemas/sitemap-image/1.1" xmlns:video="http://www.google.com/schemas/sitemap-video/1.1">' . PHP_EOL;
	}

	public static function xml_url($url, $url_image = null)
	{
		if ($url_image === null)
		{
			return '<url><loc>' . $url . '</loc></url>' . PHP_EOL;
		}

		return '<url><loc>' . $url . '</loc><image:image><image:loc>' . $url_image . '</image:loc></image:image></url>' . PHP_EOL;
	}

	public static function xml_footer()
	{
		return '</urlset>';
	}

	public static function update($sitemap_path)
	{
		return filesystem::rewrite($sitemap_path, static::xml());
	}
}