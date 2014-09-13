<?

namespace rude;

class site
{
	public static function init()
	{
		template_session::init();


		switch (get('page'))
		{
			case 'registration':
				ajax_registration::init();
				break;

			case 'authorization':
				ajax_authorization::init();
				break;

			case 'logout':
				ajax_logout::init();
				break;

			case 'add':
				$template = new template_add();
				$template->html();
				break;

			default:
				if (!url::is_homepage())
				{
					$template = new template_404();
					$template->html();

					die;
				}

				$template = new template_homepage();
				$template->html();
		}
	}
}

